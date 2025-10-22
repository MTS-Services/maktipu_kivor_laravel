<?php

namespace App\Livewire\Backend\Admin\Components\AdminManagement\Admin;

use Livewire\Component;
use App\Enums\AdminStatus;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\AdminService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use PhpParser\Node\Expr\Throw_;

class Trash extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteAdminId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;
    public $adminId;

    protected $listeners = ['adminCreated' => '$refresh', 'adminUpdated' => '$refresh'];

    protected AdminService $adminService;

    public function boot(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function render()
    {
        $admins = $this->adminService->getTrashedAdminsPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        $columns = [
            [
                'key' => 'id',
                'label' => 'ID',
                'sortable' => true
            ],
            [
                'key' => 'avatar',
                'label' => 'Avatar',
                'format' => function ($admin) {
                    return $admin->avatar_url
                        ? '<img src="' . $admin->avatar_url . '" alt="' . $admin->name . '" class="w-10 h-10 rounded-full object-cover shadow-sm">'
                        : '<div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 font-semibold">' . strtoupper(substr($admin->name, 0, 2)) . '</div>';
                }
            ],
            [
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true
            ],
            [
                'key' => 'email',
                'label' => 'Email',
                'sortable' => true
            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'sortable' => true,
                'format' => function ($admin) {
                    $colors = [
                        'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                        'inactive' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                        'suspended' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                    ];
                    $color = $colors[$admin->status->value] ?? 'bg-gray-100 text-gray-800';
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' .
                        ucfirst($admin->status->value) .
                        '</span>';
                }
            ],
            [
                'key' => 'created_at',
                'label' => 'Created',
                'sortable' => true,
                'format' => function ($admin) {
                    return '<div class="text-sm">' .
                        '<div class="font-medium text-gray-900 dark:text-gray-100">' . $admin->created_at->format('M d, Y') . '</div>' .
                        '<div class="text-xs text-gray-500 dark:text-gray-400">' . $admin->created_at->format('h:i A') . '</div>' .
                        '</div>';
                }
            ],
            [
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($admin) {
                    return $admin->createdBy
                        ? '<span class="text-sm font-medium text-gray-900 dark:text-gray-100">' . $admin->createdBy->name . '</span>'
                        : '<span class="text-sm text-gray-500 dark:text-gray-400 italic">System</span>';
                }
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'Restore',
                'method' => 'restore',
            ],
            [
                'key' => 'id',
                'label' => 'Confirm Delete',
                'method' => 'confirmDelete'
            ],
        ];

        $bulkActions = [
            ['value' => 'forceDelete', 'label' => 'Permanently Delete'],
            ['value' => 'bulkRestore', 'label' => 'Restore'],
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'deactivate', 'label' => 'Deactivate'],
            ['value' => 'suspend', 'label' => 'Suspend'],
        ];

        return view('livewire.backend.admin.components.admin-management.admin.trash', [
            'admins' => $admins,
            'statuses' => AdminStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions
        ]);
    }

    public function confirmDelete($adminId): void
    {
        $this->deleteAdminId = $adminId;
        $this->showDeleteModal = true;
    }
    public function forceDelete(): void
    {

        try {
            $this->adminService->deleteAdmin($this->deleteAdminId, forceDelete: true);
            $this->showDeleteModal = false;
            $this->resetPage();

            $this->success('Admin deleted successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to delete admin: ' . $e->getMessage());
            throw $e;
        }
    }
    public function restore($adminId): void
    {
        try {
            $this->adminService->restoreAdmin($adminId);
            
            $this->success('Admin restored successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to restore admin: ' . $e->getMessage());
            throw $e;
        }
    }
    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    public function changeStatus($adminId, $status): void
    {
        try {
            $adminStatus = AdminStatus::from($status);

            match ($adminStatus) {
                AdminStatus::ACTIVE => $this->adminService->activateAdmin($adminId),
                AdminStatus::INACTIVE => $this->adminService->deactivateAdmin($adminId),
                AdminStatus::SUSPENDED => $this->adminService->suspendAdmin($adminId),
                default => null,
            };

            $this->success('Admin status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: ' . $e->getMessage());
        }
    }
    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select Admins and an action');
            Log::info('No Admins selected or no bulk action selected');
            return;
        }

        $this->showBulkActionModal = true;
    }

    public function executeBulkAction(): void
    {
        $this->showBulkActionModal = false;

        try {
            match ($this->bulkAction) {
                // 'forceDelete' => $this->bulkDelete(),
                'forceDelete' => $this->bulkForceDeleteAdmins(),
                'bulkRestore' => $this->bulkRestoreAdmins(),
                'activate' => $this->bulkUpdateStatus(AdminStatus::ACTIVE),
                'deactivate' => $this->bulkUpdateStatus(AdminStatus::INACTIVE),
                'suspend' => $this->bulkUpdateStatus(AdminStatus::SUSPENDED),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->error('Bulk action failed: ' . $e->getMessage());
        }
    }

    protected function bulkDelete(): void
    {
        $count = $this->adminService->bulkDeleteAdmins($this->selectedIds);
        $this->success("{$count} Admins deleted successfully");
    }

    protected function bulkUpdateStatus(AdminStatus $status): void
    {
        $count = $this->adminService->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} Admins updated successfully");
    }

    protected function bulkRestoreAdmins(): void
    {
        $count = $this->adminService->bulkRestoreAdmins($this->selectedIds);
        $this->success("{$count} Admins restored successfully");
    }
    protected function bulkForceDeleteAdmins(): void
    {
        $count = $this->adminService->bulkForceDeleteAdmins($this->selectedIds);
        $this->success("{$count} Admins permanently deleted successfully");
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    protected function getSelectableIds(): array
    {
        return $this->adminService->getTrashedAdminsPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}

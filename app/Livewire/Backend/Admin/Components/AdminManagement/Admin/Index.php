<?php

namespace App\Livewire\Backend\Admin\Components\AdminManagement\Admin;

use App\Enums\AdminStatus;
use App\Models\Admin;
use App\Services\Admin\AdminService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteAdminId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

    protected $listeners = ['adminCreated' => '$refresh', 'adminUpdated' => '$refresh'];

    protected AdminService $adminService;

    public function boot(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function render()
    {
        $admins = $this->adminService->getAdminsPaginated(
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
                'label' => 'View',
                'route' => 'admin.am.admin.view',
            ],
            [
                'key' => 'id',
                'label' => 'Edit',
                'route' => 'admin.am.admin.edit'
            ],
            [
                'key' => 'id',
                'label' => 'Delete',
                'method' => 'confirmDelete'
            ],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'deactivate', 'label' => 'Deactivate'],
            ['value' => 'suspend', 'label' => 'Suspend'],
        ];

        return view('livewire.backend.admin.components.admin-management.admin.index', [
            'admins' => $admins,
            'statuses' => AdminStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($adminId): void
    {
        $this->deleteAdminId = $adminId;
        $this->showDeleteModal = true;
    }
    
    public function delete(): void
    {
        // dd($this->deleteAdminId);
        try {
            if (!$this->deleteAdminId) {
                return;
            }

            if ($this->deleteAdminId == admin()->id) {
                $this->error('You cannot delete your own account');
                return;
            }

            $this->adminService->deleteAdmin($this->deleteAdminId);

            $this->showDeleteModal = false;
            $this->deleteAdminId = null;

            $this->success('Admin deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete Admin: ' . $e->getMessage());
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
                'delete' => $this->bulkDelete(),
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
        return $this->adminService->getAdminsPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}

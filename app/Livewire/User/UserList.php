<?php

namespace App\Livewire\User;

use App\Enums\UserStatus;
use App\Services\User\UserService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('app')]
#[Title('Users')]
class UserList extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteUserId = null;
    public $bulkAction = '';

    protected $listeners = ['userCreated' => '$refresh', 'userUpdated' => '$refresh'];

    protected UserService $userService;
    public function boot(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    // public function __construct(
    //     protected UserService $userService
    // ) {
    //     parent::__construct();
    // }

    public function render()
    {
        $users = $this->userService->getUsersPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        return view('livewire.user.user-list', [
            'users' => $users,
            'statuses' => UserStatus::options(),
        ]);
    }

    public function confirmDelete($userId): void
    {
        $this->deleteUserId = $userId;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        try {
            if (!$this->deleteUserId) {
                return;
            }

            $this->userService->deleteUser($this->deleteUserId);
            
            $this->showDeleteModal = false;
            $this->deleteUserId = null;
            
            $this->success('User deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete user: ' . $e->getMessage());
        }
    }

    public function forceDelete($userId): void
    {
        try {
            $this->userService->deleteUser($userId, forceDelete: true);
            $this->success('User permanently deleted');
        } catch (\Exception $e) {
            $this->error('Failed to delete user: ' . $e->getMessage());
        }
    }

    public function restore($userId): void
    {
        try {
            $this->userService->restoreUser($userId);
            $this->success('User restored successfully');
        } catch (\Exception $e) {
            $this->error('Failed to restore user: ' . $e->getMessage());
        }
    }

    public function changeStatus($userId, $status): void
    {
        try {
            $userStatus = UserStatus::from($status);
            
            match($userStatus) {
                UserStatus::ACTIVE => $this->userService->activateUser($userId),
                UserStatus::INACTIVE => $this->userService->deactivateUser($userId),
                UserStatus::SUSPENDED => $this->userService->suspendUser($userId),
                default => null,
            };

            $this->success('User status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: ' . $e->getMessage());
        }
    }

    public function executeBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select users and an action');
            Log::info('No users selected or no bulk action selected');
            return;
        }

        try {
            match($this->bulkAction) {
                'delete' => $this->bulkDelete(),
                'activate' => $this->bulkUpdateStatus(UserStatus::ACTIVE),
                'deactivate' => $this->bulkUpdateStatus(UserStatus::INACTIVE),
                'suspend' => $this->bulkUpdateStatus(UserStatus::SUSPENDED),
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
        $count = $this->userService->bulkDeleteUsers($this->selectedIds);
        $this->success("{$count} users deleted successfully");
    }

    protected function bulkUpdateStatus(UserStatus $status): void
    {
        $count = $this->userService->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} users updated successfully");
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
        return $this->userService->getUsersPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
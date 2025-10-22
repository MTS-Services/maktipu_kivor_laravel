<?php

namespace App\Actions\Admin;

use App\Events\Admin\AdminDeleted;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAdminAction
{
    public function __construct(
        protected AdminRepositoryInterface $adminRepository
    ) {}

    public function execute(int $adminId, bool $forceDelete = false): bool
    {
        return DB::transaction(function () use ($adminId, $forceDelete) {
            $admin = $this->adminRepository->find($adminId);

            if (!$admin) {
                throw new \Exception('Admin not found');
            }

            // Dispatch event before deletion
            event(new AdminDeleted($admin));

            if ($forceDelete) {
                // Delete avatar
                if ($admin->avatar) {
                    Storage::disk('public')->delete($admin->avatar);
                }

                return $this->adminRepository->forceDelete($adminId);
            }

            return $this->adminRepository->delete($adminId);
        });
    }

    public function restore(int $adminId): bool
    {
        return $this->adminRepository->restore($adminId);
    }
}

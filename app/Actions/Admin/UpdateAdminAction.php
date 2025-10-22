<?php

namespace App\Actions\Admin;

use App\DTOs\Admin\UpdateAdminDTO;
use App\Events\Admin\AdminUpdated;
use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateAdminAction
{
    public function __construct(
        protected AdminRepositoryInterface $adminRepository
    ) {}

    public function execute(int $adminId, UpdateAdminDTO $dto): Admin
    {
        return DB::transaction(function () use ($adminId, $dto) {
            $admin = $this->adminRepository->find($adminId);

            if (!$admin) {
                Log::error('Admin not found', ['admin_id' => $adminId]);
                throw new \Exception('Admin not found');
            }

            // Store old data BEFORE any modifications
            $oldData = $admin->getAttributes();

            Log::info('Admin found', [
                'admin_id' => $adminId,
                'admin_data' => $oldData
            ]);

            Log::info('UpdateAdminDTO data', [
                'dto_data' => $dto->toArray()
            ]);

            // Get data from DTO
            $data = $dto->toArray();

            // Handle avatar upload
            if ($dto->avatar) {
                Log::info('Processing avatar upload');

                // Delete old avatar
                if ($admin->avatar) {
                    Storage::disk('public')->delete($admin->avatar);
                    Log::info('Old avatar deleted', ['path' => $admin->avatar]);
                }

                $avatarPath = $dto->avatar->store('avatars', 'public');
                $data['avatar'] = $avatarPath;

                Log::info('New avatar uploaded', ['path' => $avatarPath]);
            }

            // Handle avatar removal
            if ($dto->removeAvatar && $admin->avatar) {
                Log::info('Removing avatar', ['path' => $admin->avatar]);
                Storage::disk('public')->delete($admin->avatar);
                $data['avatar'] = null;
            }

            Log::info('Data to update', ['data' => $data]);

            // Update Admin
            $updated = $this->adminRepository->update($adminId, $data);

            if (!$updated) {
                Log::error('Failed to update Admin in repository', ['admin_id' => $adminId]);
                throw new \Exception('Failed to update Admin');
            }

            // Refresh the Admin model
            $admin = $admin->fresh();

            Log::info('Admin after update', [
                'admin_data' => $admin->getAttributes()
            ]);

            // Calculate changes - compare actual attributes, not toArray() which includes relations
            $newData = $admin->getAttributes();
            $changes = [];

            foreach ($newData as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key],
                        'new' => $value
                    ];
                }
            }

            Log::info('Changes detected', ['changes' => $changes]);

            // Dispatch event only if there are actual changes
            if (!empty($changes)) {
                event(new AdminUpdated($admin, $changes));
            }

            return $admin;
        });
    }
}

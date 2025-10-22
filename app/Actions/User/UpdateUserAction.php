<?php

namespace App\Actions\User;

use App\DTOs\User\UpdateUserDTO;
use App\Events\User\UserUpdated;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateUserAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(int $userId, UpdateUserDTO $dto): User
    {
        return DB::transaction(function () use ($userId, $dto) {
            $user = $this->userRepository->find($userId);

            if (!$user) {
                Log::error('User not found', ['user_id' => $userId]);
                throw new \Exception('User not found');
            }

            // Store old data BEFORE any modifications
            $oldData = $user->getAttributes();
            
            Log::info('User found', [
                'user_id' => $userId,
                'user_data' => $oldData
            ]);
            
            Log::info('UpdateUserDTO data', [
                'dto_data' => $dto->toArray()
            ]);

            // Get data from DTO
            $data = $dto->toArray();

            // Handle avatar upload
            if ($dto->avatar) {
                Log::info('Processing avatar upload');
                
                // Delete old avatar
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                    Log::info('Old avatar deleted', ['path' => $user->avatar]);
                }
                
                $avatarPath = $dto->avatar->store('avatars', 'public');
                $data['avatar'] = $avatarPath;
                
                Log::info('New avatar uploaded', ['path' => $avatarPath]);
            }

            // Handle avatar removal
            if ($dto->removeAvatar && $user->avatar) {
                Log::info('Removing avatar', ['path' => $user->avatar]);
                Storage::disk('public')->delete($user->avatar);
                $data['avatar'] = null;
            }

            Log::info('Data to update', ['data' => $data]);

            // Update user
            $updated = $this->userRepository->update($userId, $data);
            
            if (!$updated) {
                Log::error('Failed to update user in repository', ['user_id' => $userId]);
                throw new \Exception('Failed to update user');
            }

            // Refresh the user model
            $user = $user->fresh();
            
            Log::info('User after update', [
                'user_data' => $user->getAttributes()
            ]);

            // Calculate changes - compare actual attributes, not toArray() which includes relations
            $newData = $user->getAttributes();
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
                event(new UserUpdated($user, $changes));
            }

            return $user;
        });
    }
}
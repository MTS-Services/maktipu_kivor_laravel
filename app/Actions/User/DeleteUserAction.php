<?php

namespace App\Actions\User;

use App\Events\User\UserDeleted;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteUserAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(int $userId, bool $forceDelete = false): bool
    {
        return DB::transaction(function () use ($userId, $forceDelete) {
            $user = $this->userRepository->find($userId);

            if (!$user) {
                throw new \Exception('User not found');
            }

            // Dispatch event before deletion
            event(new UserDeleted($user));

            if ($forceDelete) {
                // Delete avatar
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                return $this->userRepository->forceDelete($userId);
            }

            return $this->userRepository->delete($userId);
        });
    }

    public function restore(int $userId): bool
    {
        return $this->userRepository->restore($userId);
    }
}
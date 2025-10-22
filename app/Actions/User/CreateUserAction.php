<?php

namespace App\Actions\User;

use App\DTOs\User\CreateUserDTO;
use App\Events\User\UserCreated;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateUserAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(CreateUserDTO $dto): User
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toArray();

            // Handle avatar upload
            if ($dto->avatar) {
                $data['avatar'] = $dto->avatar->store('avatars', 'public');
            }

            // Create user
            $user = $this->userRepository->create($data);

            // Dispatch event
            event(new UserCreated($user));

            return $user->fresh();
        });
    }
}
<?php

namespace App\Actions\Admin;

use App\DTOs\Admin\CreateAdminDTO;
use App\Events\Admin\AdminCreated;
use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateAdminAction
{
    public function __construct(
        protected AdminRepositoryInterface $adminRepository
    ) {}


    public function execute(CreateAdminDTO $dto): Admin
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toArray();

            // Handle avatar upload
            if ($dto->avatar) {
                $data['avatar'] = $dto->avatar->store('avatars', 'public');
            }

            // Create user
            $admin = $this->adminRepository->create($data);

            // Dispatch event
            event(new AdminCreated($admin));

            return $admin->fresh();
        });
    }
}

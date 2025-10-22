<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;
    
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;
    
    public function find(int $id): ?User;
    
    public function findByEmail(string $email): ?User;
    
    public function create(array $data): User;
    
    public function update(int $id, array $data): bool;
    
    public function delete(int $id): bool;
    
    public function forceDelete(int $id): bool;
    
    public function restore(int $id): bool;
    
    public function exists(int $id): bool;
    
    public function count(array $filters = []): int;
    
    public function getActive(): Collection;
    
    public function getInactive(): Collection;
    
    public function search(string $query): Collection;
    
    public function bulkDelete(array $ids): int;
    
    public function bulkUpdateStatus(array $ids, string $status): int;

    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function bulkRestore(array $ids): int;

    public function bulkForceDelete(array $ids): int;
}
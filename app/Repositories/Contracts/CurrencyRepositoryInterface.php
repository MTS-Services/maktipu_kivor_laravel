<?php

namespace App\Repositories\Contracts;

use App\Models\Currency;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CurrencyRepositoryInterface
{

    public function all(string $sortField = 'created_at' , $order = 'desc'): Collection;

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function find($column_value, string $column_name = 'id', bool $trashed = false): ?Currency;

    public function findTrashed( $column_value, string $column_name = 'id'): ?Currency;
    
    public function create(array $data): Currency;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function forceDelete(int $id): bool;

    public function restore(int $id): bool;

    public function exists(int $id): bool;

    public function count(array $filters = []): int;

    public function getActive(string $sortField = 'created_at' , $order = 'desc'): Collection;

    public function getInactive(string $sortField = 'created_at' , $order = 'desc'): Collection;

    public function search(string $query, string $sortField = 'created_at' , $order = 'desc'): Collection;

    public function bulkDelete(array $ids): int;

    public function bulkUpdateStatus(array $ids, string $status): int;

    public function bulkRestore(array $ids): int;

    public function bulkForceDelete(array $ids): int;
}

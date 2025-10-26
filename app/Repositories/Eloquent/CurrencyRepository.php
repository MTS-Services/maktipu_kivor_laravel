<?php

namespace App\Repositories\Eloquent;

use App\Models\Currency;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function __construct(
        protected Currency $model
    ) {}

    public function all(string $sortField = 'created_at' , $order = 'desc'): Collection
    {
        $query = $this->model->query();
        return $query->orderBy($sortField, $order)->get();
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->query();
        // Apply filters
        if (!empty($filters)) {
            $query->filter($filters);
        }

        // Apply sorting
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage);
    }

    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->onlyTrashed()->orderBy('deleted_at', 'desc');
        // Apply filters
        if (!empty($filters)) {
            $query->filter($filters);
        }

        // Apply sorting        
        $sortField = $filters['sort_field'] ?? 'deleted_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage);
    }

    public function find($column_value, string $column_name = 'id',  bool $trashed = false): ?Currency
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }

    public function findTrashed($column_value, string $column_name = 'id'): ?Currency
    {
        $model = $this->model->onlyTrashed();
        return $model->where($column_name, $column_value)->first();
    }

    public function create(array $data): Currency
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $currency = $this->find($id);
        
        if (!$currency) {
            return false;
        }

        return $currency->update($data);
    }

    public function delete(int $id): bool
    {
        $currency = $this->find($id);
        
        if (!$currency) {
            return false;
        }

        return $currency->delete();
    }

    public function forceDelete(int $id): bool
    {
        $currency = $this->findTrashed($id);
        
        if (!$currency) {
            return false;
        }

        return $currency->forceDelete();
    }

    public function restore(int $id): bool
    {
        $currency = $this->findTrashed($id);
        
        if (!$currency) {
            return false;
        }

        return $currency->restore();
    }

    public function exists(int $id): bool
    {
        return $this->model->where('id', $id)->exists();
    }

    public function count(array $filters = []): int
    {
        $query = $this->model->query();

        if (!empty($filters)) {
            $query->filter($filters);
        }

        return $query->count();
    }

    public function getActive(string $sortField = 'created_at' , $order = 'desc'): Collection
    {
        return $this->model->active()->orderBy($sortField, $order)->get();
    }

    public function getInactive(string $sortField = 'created_at' , $order = 'desc'): Collection
    {
        return $this->model->inactive()->orderBy($sortField, $order)->get();
    }

    public function search(string $query, string $sortField = 'created_at' , $order = 'desc'): Collection
    {
        return $this->model->search($query)->orderBy($sortField, $order)->get();
    }

    public function bulkDelete(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function bulkUpdateStatus(array $ids, string $status): int
    {
        return $this->model->whereIn('id', $ids)->update(['status' => $status]);
    }
    public function bulkRestore(array $ids): int
    {
         return $this->model->onlyTrashed()->whereIn('id', $ids)->restore();
    }
    public function bulkForceDelete(array $ids): int //
    {  
        return $this->model->onlyTrashed()->whereIn('id', $ids)->forceDelete();
    }
}
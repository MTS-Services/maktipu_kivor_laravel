<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AdminRepository implements AdminRepositoryInterface
{
    public function __construct(
        protected Admin $model
    ) {}

    public function all(): Collection
    {
        return $this->model->orderBy('created_at', 'desc')->get();
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

    public function find(int $id): ?Admin
    {
        return $this->model->withTrashed()->find($id);
    }

    public function findByEmail(string $email): ?Admin
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $data): Admin
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $admin = $this->find($id);
        
        if (!$admin) {
            return false;
        }

        return $admin->update($data);
    }

    public function delete(int $id): bool
    {
        $admin = $this->find($id);
        
        if (!$admin) {
            return false;
        }

        return $admin->delete();
    }

    public function forceDelete(int $id): bool
    {
        $admin = $this->model->onlyTrashed()->find($id);
        
        if (!$admin) {
            return false;
        }

        return $admin->forceDelete();
    }

    public function restore(int $id): bool
    {
        $admin = $this->model->withTrashed()->find($id);
        
        if (!$admin) {
            return false;
        }

        return $admin->restore();
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

    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }

    public function getInactive(): Collection
    {
        return $this->model->inactive()->get();
    }

    public function search(string $query): Collection
    {
        return $this->model->search($query)->get();
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
         return $this->model->withTrashed()->whereIn('id', $ids)->restore();
    }
    public function bulkForceDelete(array $ids): int //
    {  
        return $this->model->withTrashed()->whereIn('id', $ids)->forceDelete();
    }
}
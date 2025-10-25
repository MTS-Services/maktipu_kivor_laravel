<?php

namespace App\Repositories\Eloquent;

use App\Models\Language;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function __construct(
        protected Language $model
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

    public function find(int $id): ?Language
    {
        return $this->model->withTrashed()->find($id);
    }

    public function findByEmail(string $email): ?Language
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $data): Language
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $language = $this->find($id);
        
        if (!$language) {
            return false;
        }

        return $language->update($data);
    }

    public function delete(int $id): bool
    {
        $language = $this->find($id);
        
        if (!$language) {
            return false;
        }

        return $language->delete();
    }

    public function forceDelete(int $id): bool
    {
        $language = $this->model->onlyTrashed()->find($id);
        
        if (!$language) {
            return false;
        }

        return $language->forceDelete();
    }

    public function restore(int $id): bool
    {
        $language = $this->model->withTrashed()->find($id);
        
        if (!$language) {
            return false;
        }

        return $language->restore();
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
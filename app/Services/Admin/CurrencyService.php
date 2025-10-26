<?php

namespace App\Services\Admin;

use App\Actions\Currency\CreateAction;
use App\Actions\Currency\DeleteAction;
use App\Actions\Currency\UpdateAction;
use App\DTOs\Currency\CreateDTO;
use App\DTOs\Currency\UpdateDTO;
use App\Enums\CurrencyStatus;
use App\Models\Currency;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CurrencyService
{
    public function __construct(
        protected CurrencyRepositoryInterface $currencyInterface,
        protected CreateAction $createAction,
        protected UpdateAction $updateAction,
        protected DeleteAction $deleteAction,
    ) {}

    public function getAll($sortField = 'created_at' , $order = 'desc'): Collection
    {
        return $this->currencyInterface->all($sortField, $order);
    }

    public function getPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->currencyInterface->paginate($perPage, $filters);
    }

    public function findData($column_value, string $column_name = 'id'): ?Currency
    {
        return $this->currencyInterface->find($column_value, $column_name);
    }

    public function createData(CreateDTO $dto): Currency
    {
        return $this->createAction->execute($dto);
    }

    public function updateData(int $id, UpdateDTO $dto): Currency
    {
        return $this->updateAction->execute($id, $dto);
    }

    public function deleteData(int $id, bool $forceDelete = false): bool
    {
        return $this->deleteAction->execute($id, $forceDelete);
    }

    public function restoreData(int $id): bool
    {
        return $this->deleteAction->restore($id);
    }

    public function getActiveData($sortField = 'created_at' , $order = 'desc'): Collection
    {
        return $this->currencyInterface->getActive($sortField , $order);
    }

    public function getInactiveData($sortField = 'created_at' , $order = 'desc'): Collection
    {
        return $this->currencyInterface->getInactive($sortField , $order);
    }

    public function searchData(string $query, $sortField = 'created_at' , $order = 'desc'): Collection
    {
        return $this->currencyInterface->search($query,$sortField , $order);
    }

    public function bulkDeleteData(array $ids): int
    {
        return $this->currencyInterface->bulkDelete($ids);
    }

    public function bulkUpdateStatus(array $ids, CurrencyStatus $status): int
    {
        return $this->currencyInterface->bulkUpdateStatus($ids, $status->value);
    }

    public function getDataCount(array $filters = []): int
    {
        return $this->currencyInterface->count($filters);
    }

    public function dataExists(int $id): bool
    {
        return $this->currencyInterface->exists($id);
    }

    public function activateData(int $id): bool
    {
        $currency = $this->findData($id);

        if (!$currency) {
            return false;
        }

        $currency->activate();
        return true;
    }

    public function deactivateData(int $id): bool
    {
        $currency = $this->findData($id);

        if (!$currency) {
            return false;
        }

        $currency->deactivate();
        return true;
    }

    public function suspendData(int $id): bool
    {
        $currency = $this->findData($id);

        if (!$currency) {
            return false;
        }

        $currency->suspend();
        return true;
    }
    public function getTrashedDataPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->currencyInterface->trashPaginate($perPage, $filters);
    }

    public function bulkRestoreData(array $ids): int
    {
        return $this->currencyInterface->bulkRestore($ids);
    }

    public function bulkForceDeleteData(array $ids): int
    {
        return $this->currencyInterface->bulkForceDelete($ids);
    }
}

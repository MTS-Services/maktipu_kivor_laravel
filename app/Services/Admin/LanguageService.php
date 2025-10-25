<?php

namespace App\Services\Admin;

use App\Actions\Language\CreateLanguageAction;
use App\Actions\Language\DeleteLanguageAction;
use App\Actions\Language\UpdateLanguageAction;
use App\DTOs\Language\CreateLanguageDTO;
use App\DTOs\Language\UpdateLanguageDTO;
use App\Enums\LanguageStatus;
use App\Models\Language;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class LanguageService
{
    public function __construct(
        protected LanguageRepositoryInterface $languageRepository,
        protected CreateLanguageAction $createLanguageAction,
        protected UpdateLanguageAction $updateLanguageAction,
        protected DeleteLanguageAction $deleteLanguageAction,
    ) {}

    public function getAllLanguages(): Collection
    {
        return $this->languageRepository->all();
    }

    public function getLanguagesPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->languageRepository->paginate($perPage, $filters);
    }

    public function getLanguageById(int $id): ?Language
    {
        return $this->languageRepository->find($id);
    }

    public function getLanguageByEmail(string $email): ?Language
    {
        return $this->languageRepository->findByEmail($email);
    }

    public function createLanguage(CreateLanguageDTO $dto): Language
    {
        return $this->createLanguageAction->execute($dto);
    }

    public function updateLanguage(int $id, UpdateLanguageDTO $dto): Language
    {
        return $this->updateLanguageAction->execute($id, $dto);
    }

    public function deleteLanguage(int $id, bool $forceDelete = false): bool
    {
        return $this->deleteLanguageAction->execute($id, $forceDelete);
    }

    public function restoreLanguage(int $id): bool
    {
        return $this->deleteLanguageAction->restore($id);
    }

    public function getActiveLanguages(): Collection
    {
        return $this->languageRepository->getActive();
    }

    public function getInactiveLanguages(): Collection
    {
        return $this->languageRepository->getInactive();
    }

    public function searchLanguages(string $query): Collection
    {
        return $this->languageRepository->search($query);
    }

    public function bulkDeleteLanguages(array $ids): int
    {
        return $this->languageRepository->bulkDelete($ids);
    }

    public function bulkUpdateStatus(array $ids, LanguageStatus $status): int
    {
        return $this->languageRepository->bulkUpdateStatus($ids, $status->value);
    }

    public function getLanguagesCount(array $filters = []): int
    {
        return $this->languageRepository->count($filters);
    }

    public function languageExists(int $id): bool
    {
        return $this->languageRepository->exists($id);
    }

    public function activateLanguage(int $id): bool
    {
        $language = $this->getLanguageById($id);

        if (!$language) {
            return false;
        }

        $language->activate();
        return true;
    }

    public function deactivateLanguage(int $id): bool
    {
        $language = $this->getLanguageById($id);

        if (!$language) {
            return false;
        }

        $language->deactivate();
        return true;
    }

    public function suspendLanguage(int $id): bool
    {
        $language = $this->getLanguageById($id);

        if (!$language) {
            return false;
        }

        $language->suspend();
        return true;
    }
    public function getTrashedLanguagesPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->languageRepository->trashPaginate($perPage, $filters);
    }

    public function bulkRestoreLanguages(array $ids): int
    {
        return $this->languageRepository->bulkRestore($ids);
    }

    public function bulkForceDeleteLanguages(array $ids): int
    {
        return $this->languageRepository->bulkForceDelete($ids);
    }
}

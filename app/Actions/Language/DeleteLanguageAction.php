<?php

namespace App\Actions\Language;

use App\Events\Language\LanguageDeleted;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteLanguageAction
{
    public function __construct(
        protected LanguageRepositoryInterface $languageRepository
    ) {}

    public function execute(int $languageId, bool $forceDelete = false): bool
    {
        return DB::transaction(function () use ($languageId, $forceDelete) {
            $language = $this->languageRepository->find($languageId);

            if (!$language) {
                throw new \Exception('Admin not found');
            }

            // Dispatch event before deletion
            event(new LanguageDeleted($language));

            if ($forceDelete) {
                // Delete avatar
                if ($language->avatar) {
                    Storage::disk('public')->delete($language->avatar);
                }

                return $this->languageRepository->forceDelete($languageId);
            }

            return $this->languageRepository->delete($languageId);
        });
    }

    public function restore(int $languageId): bool
    {
        return $this->languageRepository->restore($languageId);
    }
}

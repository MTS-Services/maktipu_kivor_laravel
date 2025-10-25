<?php

namespace App\Actions\Language;

use App\DTOs\Language\UpdateLanguageDTO;
use App\Events\Language\LanguageUpdated;
use App\Models\Language;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateLanguageAction
{
    public function __construct(
        protected LanguageRepositoryInterface $languageRepository
    ) {}

    public function execute(int $languageId, UpdateLanguageDTO $dto): Language
    {
        return DB::transaction(function () use ($languageId, $dto) {

            // Fetch language
            $language = $this->languageRepository->find($languageId);

            if (!$language) {
                Log::error('Language not found', ['language_id' => $languageId]);
                throw new \Exception('Language not found');
            }

            $oldData = $language->getAttributes();
            $data = $dto->toArray();

            // Update language
            $updated = $this->languageRepository->update($languageId, $data);

            if (!$updated) {
                Log::error('Failed to update Language', ['language_id' => $languageId]);
                throw new \Exception('Failed to update Language');
            }

            // Refresh model
            $language = $language->fresh();

            // Detect changes
            $changes = [];
            foreach ($language->getAttributes() as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key],
                        'new' => $value
                    ];
                }
            }

            // Fire event if changes exist
            if (!empty($changes)) {
                event(new LanguageUpdated($language, $changes));
            }

            return $language;
        });
    }
}

<?php

namespace App\Actions\Language;

use App\DTOs\Language\UpdateLanguageDTO;
use App\Events\Language\LanguageUpdated;
use App\Models\Language;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateLanguageAction
{
    public function __construct(
        protected LanguageRepositoryInterface $languageRepository
    ) {}

    public function execute(int $languageId, UpdateLanguageDTO $dto): Language
    {
        return DB::transaction(function () use ($languageId, $dto) {
            $language = $this->languageRepository->find($languageId);

            if (!$language) {
                Log::error('Admin not found', ['admin_id' => $languageId]);
                throw new \Exception('Admin not found');
            }

            // Store old data BEFORE any modifications
            $oldData = $language->getAttributes();

            Log::info('Admin found', [
                'admin_id' => $languageId,
                'admin_data' => $oldData
            ]);

            Log::info('UpdateAdminDTO data', [
                'dto_data' => $dto->toArray()
            ]);

            // Get data from DTO
            $data = $dto->toArray();

            // Handle avatar upload
            if ($dto->avatar) {
                Log::info('Processing avatar upload');

                // Delete old avatar
                if ($language->avatar) {
                    Storage::disk('public')->delete($language->avatar);
                    Log::info('Old avatar deleted', ['path' => $language->avatar]);
                }

                $avatarPath = $dto->avatar->store('avatars', 'public');
                $data['avatar'] = $avatarPath;

                Log::info('New avatar uploaded', ['path' => $avatarPath]);
            }

            // Handle avatar removal
            if ($dto->removeAvatar && $language->avatar) {
                Log::info('Removing avatar', ['path' => $language->avatar]);
                Storage::disk('public')->delete($language->avatar);
                $data['avatar'] = null;
            }

            Log::info('Data to update', ['data' => $data]);

            // Update Admin
            $updated = $this->languageRepository->update($languageId, $data);

            if (!$updated) {
                Log::error('Failed to update Admin in repository', ['admin_id' => $languageId]);
                throw new \Exception('Failed to update Admin');
            }

            // Refresh the Admin model
            $language = $language->fresh();

            Log::info('Admin after update', [
                'admin_data' => $language->getAttributes()
            ]);

            $newData = $language->getAttributes();
            $changes = [];

            foreach ($newData as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key],
                        'new' => $value
                    ];
                }
            }

            Log::info('Changes detected', ['changes' => $changes]);

            if (!empty($changes)) {
                event(new LanguageUpdated($language, $changes));
            }

            return $language;
        });
    }
}

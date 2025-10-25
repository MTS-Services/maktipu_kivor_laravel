<?php

namespace App\Actions\Language;

use App\DTOs\Language\CreateLanguageDTO;
use App\Events\Language\LanguageCreated;
use App\Models\Language;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateLanguageAction
{
    public function __construct(
        protected LanguageRepositoryInterface $languageRepository
    ) {}


    public function execute(CreateLanguageDTO $dto): Language
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toArray();

            // Create user
            $language = $this->languageRepository->create($data);

            // Dispatch event
            event(new LanguageCreated($language));

            return $language->fresh();
        });
    }
}

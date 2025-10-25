<?php

namespace Database\Seeders;

use App\Enums\LanguageDirections;
use App\Enums\LanguageStatus;
use Illuminate\Database\Seeder;
use App\Models\Language;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('languages')->truncate();

        $languages = [
            [
                'locale' => 'en',
                'name' => 'English',
                'native_name' => 'English',
                'flag_icon' => 'flags/en.png',
                'status' => LanguageStatus::ACTIVE->value,
                'is_default' => true,
                'direction' => LanguageDirections::LTR->value,
            ],
            [
                'locale' => 'es',
                'name' => 'Spanish',
                'native_name' => 'Español',
                'flag_icon' => 'flags/es.png',
                'status' => LanguageStatus::ACTIVE->value,
                'is_default' => true,
                'direction' => LanguageDirections::LTR->value,
            ],
            [
                'locale' => 'fr',
                'name' => 'French',
                'native_name' => 'Français',
                'flag_icon' => 'flags/fr.png',
                'status' => LanguageStatus::ACTIVE->value,
                'is_default' => true,
                'direction' => LanguageDirections::LTR->value,
            ],
            [
                'locale' => 'bn',
                'name' => 'Bengali',
                'native_name' => 'বাংলা',
                'flag_icon' => 'flags/bn.png',
               'status' => LanguageStatus::ACTIVE->value,
                'is_default' => true,
                'direction' => LanguageDirections::LTR->value,
            ],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Enums\CurrencyStatus;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('currencies')->truncate();

        $currencies = [
            [
                'code' => 'USD',
                'symbol' => '&#xa3;',
                'name' => 'US Dollar',
                'exchange_rate' => 1,
                'decimal_places' => 2,
                'status' => CurrencyStatus::ACTIVE->value,
                'is_default' => true,
            ],
            [
                'code' => 'DBT',
                'symbol' => '&#xa2;',
                'name' => 'Bangladeshi Taka',
                'exchange_rate' => 108.500000,
                'decimal_places' => 2,
                'status' => CurrencyStatus::ACTIVE->value,
                'is_default' => false,
            ],
           
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}

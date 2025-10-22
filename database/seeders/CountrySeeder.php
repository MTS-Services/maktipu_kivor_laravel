<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'United States', 'code' => 'US', 'phone_code' => '+1', 'currency' => 'USD', 'is_active' => true],
            ['name' => 'United Kingdom', 'code' => 'GB', 'phone_code' => '+44', 'currency' => 'GBP', 'is_active' => true],
            ['name' => 'Bangladesh', 'code' => 'BD', 'phone_code' => '+880', 'currency' => 'BDT', 'is_active' => true],
            ['name' => 'Canada', 'code' => 'CA', 'phone_code' => '+1', 'currency' => 'CAD', 'is_active' => true],
            ['name' => 'Australia', 'code' => 'AU', 'phone_code' => '+61', 'currency' => 'AUD', 'is_active' => true],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}

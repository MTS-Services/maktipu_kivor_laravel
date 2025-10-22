<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\SellerLevel;
use App\Models\SellerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Get some users to assign as sellers
        $users = User::inRandomOrder()->take(10)->get(); // adjust the number of sellers

        foreach ($users as $user) {
            SellerProfile::create([
                'sort_order' => $faker->numberBetween(1, 100),
                'user_id' => $user->id,
                'shop_name' => $faker->company,
                'shop_description' => $faker->paragraph(2),
                'seller_verified' => $faker->boolean(70), // 70% chance of being verified
                'seller_verified_at' => $faker->boolean(70) ? now() : null,
                'seller_level' => SellerLevel::cases()[array_rand(SellerLevel::cases())]->value,
                'commission_rate' => $faker->randomFloat(2, 5, 20), // 5% to 20%
                'minimum_payout' => $faker->randomFloat(2, 50, 500),
            ]);
        }
    }
}

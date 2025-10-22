<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserStatistic;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserStatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            UserStatistic::create([
                'sort_order' => 0,
                'user_id' => $user->id,
                'total_orders_as_buyer' => rand(0, 50),
                'total_spent' => rand(1000, 50000) / 1.5,
                'total_orders_as_seller' => rand(0, 100),
                'total_earned' => rand(5000, 200000) / 1.3,
                'average_rating_as_seller' => rand(30, 50) / 10, // 3.0 to 5.0 range
                'total_reviews_as_seller' => rand(0, 200),
            ]);
        }
    }
}

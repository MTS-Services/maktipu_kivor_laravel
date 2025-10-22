<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\UserReferral;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserReferralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('id')->toArray();

        if (count($users) < 2) {
            $this->command->warn('⚠️ Need at least 2 users to create referrals.');
            return;
        }
        foreach (range(1, 10) as $i) {
            $userId = $users[array_rand($users)];
            $referredBy = $users[array_rand($users)];

            // Avoid self-referral
            if ($userId === $referredBy) {
                continue;
            }

            UserReferral::create([
                'sort_order'        => $i,
                'user_id'           => $userId,
                'referred_by'       => $referredBy,
                'referral_code'     => strtoupper(Str::random(10)),
                'referral_earnings' => fake()->randomFloat(2, 0, 500),
            ]);
        }
    }
}

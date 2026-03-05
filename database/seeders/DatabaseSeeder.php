<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@berrni.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'phone' => '+33000000000',
                'role' => 'admin',
                'is_verified' => true,
            ]
        );
        Wallet::firstOrCreate(['user_id' => $admin->id], ['balance_available' => 0, 'balance_sequestered' => 0]);

        // Call other seeders
        $this->call([
            UserSeeder::class,
            KycSeeder::class,
            ParcelSeeder::class,
            // TransactionSeeder::class,
        ]);
    }
}

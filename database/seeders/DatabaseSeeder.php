<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin User
        User::updateOrCreate(
            ['email' => 'superadmin@zalvlmax.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superadmin123'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@zalvlmax.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Call other seeders
        $this->call([
            CategorySeeder::class,
            SettingSeeder::class,
            QuizSeeder::class,
        ]);
    }
}



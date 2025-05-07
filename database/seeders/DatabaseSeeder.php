<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'super@quranlms.com'],
            [
              'name'     => 'Super Admin',
              'password' => 'secret123',        // will be hashed
              'role'     => User::ROLE_SUPER_ADMIN,
            ]
        );
    }
}

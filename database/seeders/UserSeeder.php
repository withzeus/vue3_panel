<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'super@gmail.com'],
            [
                'name' => 'SUPER ADMIN',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (app()->environment('local', 'testing')) {
            User::factory()->count(10)->create();
        }
    }
}

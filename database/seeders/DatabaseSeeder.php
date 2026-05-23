<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        $users = [
            [
                'name' => 'Teacher',
                'email' => 'teacher@test.com',
                'role' => 'teacher',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Teacher 2',
                'email' => 'teacher2@test.com',
                'role' => 'teacher',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password'),
                    'role' => $user['role'],
                ]
            );
        }
    }
}

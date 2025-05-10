<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Only',
                'email' => 'admin@god.com',
                'role' => 'Admin',
            ],
            [
                'name' => 'Pharmacist Admin',
                'email' => 'Pharmacist@example.com',
                'role' => 'Pharmacist',
            ],
            [
                'name' => 'Staff Tech',
                'email' => 'technician@example.com',
                'role' => 'Technician',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password'), // default password
                'status' => 'active',
                'role' => $user['role'],
            ]);
        }
    }
}

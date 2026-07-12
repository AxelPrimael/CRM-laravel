<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            [
                'email' => 'admin@crm.com',
            ],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin12345!'),
            ]
        );

        $user->assignRole('Super Admin');
    }
}
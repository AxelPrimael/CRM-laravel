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
        // Création d'un utilisateur test
        User::firstOrCreate(
            [
                'email' => 'test@example.com'
            ],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        // Création des rôles et permissions
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Création du compte administrateur
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}
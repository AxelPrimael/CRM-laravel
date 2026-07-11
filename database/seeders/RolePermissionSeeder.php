<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [

            'contact.view',
            'contact.create',
            'contact.edit',
            'contact.delete',

            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

        ];


        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission,
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin'
        ]);


        $admin = Role::firstOrCreate([
            'name' => 'Admin'
        ]);


        $user = Role::firstOrCreate([
            'name' => 'User'
        ]);



        /*
        |--------------------------------------------------------------------------
        | Permissions Super Admin
        |--------------------------------------------------------------------------
        */

        $superAdmin->givePermissionTo(
            Permission::all()
        );



        /*
        |--------------------------------------------------------------------------
        | Permissions Admin
        |--------------------------------------------------------------------------
        */

        $admin->givePermissionTo([

            'contact.view',
            'contact.create',
            'contact.edit',
            'contact.delete',

        ]);



        /*
        |--------------------------------------------------------------------------
        | Permissions User
        |--------------------------------------------------------------------------
        */

        $user->givePermissionTo([

            'contact.view',

        ]);

    }
}
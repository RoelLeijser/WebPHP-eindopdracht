<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'contract accepted']);
        Permission::create(['name' => 'edit accounts']);
        Permission::create(['name' => 'delete accounts']);

        // Advertisement permissions
        Permission::create(['name' => 'create advertisements']);
        Permission::create(['name' => 'edit advertisements']);
        Permission::create(['name' => 'delete advertisements']);
        Permission::create(['name' => 'favorite advertisements']);
        Permission::create(['name' => 'bid advertisements']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'basis gebruiker']);
        Role::create(['name' => 'particuliere adverteerder']);
        Role::create(['name' => 'zakelijke adverteerder']);

        Role::findByName('admin')->givePermissionTo(Permission::all());

        Role::findByName('basis gebruiker')->givePermissionTo([
            'favorite advertisements',
            'bid advertisements',
        ]);

        Role::findByName('particuliere adverteerder')->givePermissionTo([
            'create advertisements',
            'edit advertisements',
            'delete advertisements',
            'favorite advertisements',
            'bid advertisements',
        ]);

        Role::findByName('zakelijke adverteerder')->givePermissionTo([
            'create advertisements',
            'edit advertisements',
            'delete advertisements',
            'favorite advertisements',
            'bid advertisements',
            'contract accepted',
        ]);
    }
}

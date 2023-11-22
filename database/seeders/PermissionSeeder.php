<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create permissions
        Permission::create(['name' => 'menu-config']);
        Permission::create(['name' => 'menu-masterdata']);
        Permission::create(['name' => 'menu-procurement']);
        Permission::create(['name' => 'menu-vendor']);
        Permission::create(['name' => 'menu-tender']);
        Permission::create(['name' => 'menu-isoreport']);
        Permission::create(['name' => 'menu-setting']);
        Permission::create(['name' => 'menu-logactivity']);

        Permission::create(['name' => 'submenu-division']);
        Permission::create(['name' => 'submenu-official']);
        Permission::create(['name' => 'submenu-core-business']);
        Permission::create(['name' => 'submenu-classification']);

        Permission::create(['name' => 'delete-file-category']);

        Permission::create(['name' => 'user-index']);
        Permission::create(['name' => 'user-create']);
        Permission::create(['name' => 'user-edit']);
        Permission::create(['name' => 'user-delete']);

        Permission::create(['name' => 'role-index']);
        Permission::create(['name' => 'role-create']);
        Permission::create(['name' => 'role-edit']);
        Permission::create(['name' => 'role-delete']);

        Permission::create(['name' => 'permission-index']);
        Permission::create(['name' => 'permission-create']);
        Permission::create(['name' => 'permission-edit']);
        Permission::create(['name' => 'permission-delete']);
    }
}

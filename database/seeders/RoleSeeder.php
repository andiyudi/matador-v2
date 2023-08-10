<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create roles
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Umum']);
        Role::create(['name' => 'Pengadaan']);
    }
}

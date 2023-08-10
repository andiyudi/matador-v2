<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create users
        $user = User::create([
            'name' => "Administrator",
            'username' => "admin",
            'email' => "admin@mail.com",
            'password' => Hash::make("password")
        ]);

        $permission = Permission::all();

        $role = Role::find(1);

        $role->syncPermissions($permission);

        $user->assignRole($role);
    }
}

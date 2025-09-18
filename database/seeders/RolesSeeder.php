<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Admin', 'HR', 'Gateman', 'Employee', 'Intern'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create an admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );
        $admin->assignRole('Admin');

        // Create a gateman
        $gateman = User::firstOrCreate(
            ['email' => 'gateman@example.com'],
            ['name' => 'Gate Man', 'password' => bcrypt('password')]
        );
        $gateman->assignRole('Gateman');
    }
}

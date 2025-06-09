<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the superadmin role exists
        $role = Role::firstOrCreate(['name' => 'superadmin']);

        // Create or update superadmin user with role attribute set
        $superAdmin = User::updateOrCreate(
            ['email' => 'rashinhamza2002@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('rashin2002'),
                'email_verified_at' => now(),
                'role' => 'superadmin',  // Set the role column explicitly here
            ]
        );

        // Assign the spatie permission role as well
        $superAdmin->assignRole($role);
    }
}

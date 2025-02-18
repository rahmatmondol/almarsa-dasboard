<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ]);

        $superAdmin = \App\Models\User::factory()->create([
            'name' => 'rahmat mondol',
            'email' => 'rahmat.mondol007@gmail.com',
            'password' => bcrypt('Ra01713754417'),
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $userRole = Role::create(['name' => 'customer']);

        $permissions = Permission::all();
        $adminRole->givePermissionTo($permissions);
        $admin->assignRole($adminRole);
        $superAdmin->assignRole($superAdminRole);
    }
}

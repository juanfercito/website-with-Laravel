<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Refer to Models
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            "name" => "admin2",
            "email" => "admin2@mail.com",
            "password" => bcrypt("admin123"),
        ]);

        $rol = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $rol->syncPermissions($permissions);
        $user->assignRole($rol->id);
    }
}

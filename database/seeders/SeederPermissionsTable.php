<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Spatie
use Spatie\Permission\Models\Permission;

class SeederPermissionsTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // table users
            'watch-users',
            'insert-user',
            'modify-user',
            'delete-user',

            // table products
            'watch-products',
            'insert-product',
            'modify-product',
            'delete-product',

            // table providers
            'watch-providers',
            'insert-provider',
            'modify-provider',
            'delete-provider',

            // table shipping
            'watch-shipping',
            'insert-shipping',
            'modify-shipping',
            'delete-shipping',

            // table roles
            'watch-roles',
            'insert-role',
            'modify-role',
            'delete-role',

            // table incomes
            'watch-incomes',
            'insert-income',
            'modify-income',
            'delete-income',

            // table sales
            'watch-sales',
            'insert-sale',
            'modify-sale',
            'delete-sale',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        };
    }
}

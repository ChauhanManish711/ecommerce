<?php

use Database\Seeders\UsersSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\RoleshasPermissionSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // PermissionSeeder::class,
            // UsersSeeder::class,
            // ProductSeeder::class,
            // BrandSeeder::class,
            // RoleSeeder::class,
            RoleshasPermissionSeeder::class,

        ]);
    }
}

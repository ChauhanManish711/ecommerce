<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id'=>2,'name'=>'Admin'],
            ['id'=>3,'name'=> 'Marketing'],
            ['id'=>4,'name'=> 'Sales'],
            ['id'=>5,'name' => 'Client'],
            ['id'=>6,'name' => 'User']
        ];
        foreach($roles as $role)
        {
            Role::create($role);
        }
    }
}

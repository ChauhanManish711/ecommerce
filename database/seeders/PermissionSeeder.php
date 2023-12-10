<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['id'=>1,'name'=>'admin-dashboard'],
            ['id'=>2,'name'=>'user-dashboard'],
            ['id'=>3,'name'=>'role-list'],
            ['id'=>4,'name'=>'role-create'],
            ['id'=>5,'name'=>'role-edit'],
            ['id'=>6,'name'=>'role-delete'],
            ['id'=>7,'name'=>'product-list'],
            ['id'=>8,'name'=>'product-create'],
            ['id'=>9,'name'=>'product-edit'],
            ['id'=>10,'name'=>'product-delete'],
            ['id'=>11,'name'=>'users-list'],
            ['id'=>12,'name'=>'users-create'],
            ['id'=>13,'name'=>'users-delete'],
            ['id'=>14,'name'=>'users-edit'],
            ['id'=>15,'name'=>'add-permission'],
            ['id'=>16,'name'=>'give-permission'],
            ['id'=>17,'name'=>'delete-permission'],
            ['id'=>18,'name'=>'edit-permission'],
        ];

        foreach($permissions as $permission)
        {
            Permission::create($permission);
        }
    }
}

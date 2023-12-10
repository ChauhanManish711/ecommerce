<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
                'name'=>'manish',
                'email'=>'chauhanmanish711@gmail.com',
                'password'=> Hash::make('password123#')
        ]);

       $role = Role::create(['id'=>1,'name'=>'Super Admin']);

       $permissions = Permission::pluck('id','id')->all();

       $role->syncPermissions($permissions);

       $user->assignRole($role);

    }
}

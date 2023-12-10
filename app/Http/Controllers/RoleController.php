<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function roles()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('auth.role',compact('roles','permissions'));
    }
    public function add_role(Request $request)
    {
        //get last record from database
        $get_last = Role::orderBy('id','desc')->first();

        //get role
        $role_detail = [
            'name' =>  $request->role_name,
            'guard_name' => 'web'
        ];

        //get permissions 
        $permissions = $request->permission;
        try{
            //create role
            $new_role = Role::create($role_detail);

            //assign permissions
            foreach($permissions as $permission)
            {
                $new_role->givePermissionTo($permission);
            }
            \Session::flash("success",'Successfully created a role.');
            return redirect()->route('roles');
        }catch(\Exception $e)
        {
            \Session::flash("error",$e->getMessage());
            return redirect()->route('roles');
        }
    }
}

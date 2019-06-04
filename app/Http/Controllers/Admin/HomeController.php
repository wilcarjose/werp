<?php

namespace Werp\Http\Controllers\Admin;

use Werp\User;
use Werp\Role;
use Werp\Admin;
use Werp\Permission;
use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = collect();
        $data->usersCount      = User::count();
        $data->adminCount      = Admin::count();
        $data->roleCount       = Role::count();
        $data->permissionCount = Permission::count();

        $data->roles = Role::all();
        $data->permissions = Permission::all();
        return view('admin.home', compact('data'));
    }
}

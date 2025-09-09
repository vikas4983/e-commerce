<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

trait HasRolePermissionCheck
{
    public function getRoleByID($roleId)
    {
        return  Role::where('id', $roleId)->where('guard_name', 'api')->firstOrFail();
    }
    public function getPermissionByID($permissionId)
    {
        return Permission::where('id', $permissionId)->where('guard_name', 'api')->firstOrFail();
    }
}

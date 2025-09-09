<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRolePermissionRequest;
use App\Http\Requests\AssignUserRoleRequest;
use App\Models\User;
use App\Traits\HandlesAuthUser;
use App\Traits\HasRolePermissionCheck;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionAssignmentController extends Controller
{
    use HandlesAuthUser;
    use HasRolePermissionCheck;

    public function assignRoleToUser(AssignUserRoleRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->getUser($validatedData);
        $newRoles = collect($validatedData['roles'])->sort()->values();
        foreach ($validatedData['roles'] as $role) {
            if (!$user->hasRole($role)) {
                $user->assignRole($role);
                $roles = $user->getRoleNames();
                return ApiResponse::success(__('messages.assign_role_created'),  $roles);
            }
        }
        return ApiResponse::already(__('messages.assign_role_already'), $newRoles);
    }
    public function revokeRoleFromUser(AssignUserRoleRequest $request)
    {
        $validatedData = $request->validated();
        $removeRole = [];
        $user = $this->getUser($validatedData);
        foreach ($validatedData['roles'] as $role) {
            if (!$user->hasRole($role)) {
                return ApiResponse::error(__('messages.revoke_role_not_found'), $validatedData['roles']);
            }
            $user->removeRole($role);
            $removeRole[] = $role;
        }
        return ApiResponse::success(__('messages.revoke_role_deleted'),  $removeRole);
    }
    public function assignPermissionToRole(AssignRolePermissionRequest $request)
    {
        $validatedData  = $request->validated();
        $permissionIds = $validatedData['permission_id'];
        $roleId = $validatedData['role_id'];
        $role = $this->getRoleById($roleId);
        $rolePermissionIds = $role->getAllPermissions()->pluck('id');
        $allPresent = collect($permissionIds)->every(fn($id) => $rolePermissionIds->contains($id));
        if (!$allPresent) {
            foreach ($validatedData['role_id'] as $roleId) {
                $role = $this->getRoleById($roleId);
                foreach ($validatedData['permission_id'] as $permissionId) {
                    $permission = $this->getPermissionById($permissionId);
                    if (!$role->hasPermissionTo($permission->name)) {
                        $permissions = $role->givePermissionTo($permission->name);
                    }
                }
            }
            return ApiResponse::success(__('messages.assign_role_permission_created'),  $permissions ?? '');
        }
        return ApiResponse::already(__('messages.assign_role_permission_already'),   $role->getAllPermissions() ?? '');
    }



    public function revokePermissionFromRole(AssignRolePermissionRequest $request)
    {
        $validatedData = $request->validated();
        $permissions = $validatedData['permission_id'];
        $roleId = $validatedData['role_id'];
        $role = $this->getRoleById($roleId);
        $rolePermissionIds = $role->getAllPermissions()->pluck('id');
        $exist = collect($permissions)->every(fn($id) => $rolePermissionIds->contains($id));
        if (!$exist) {
            return ApiResponse::error(__('messages.assign_role_permission_not_found'),  $permissions);
        }
        foreach ($validatedData['role_id'] as $key => $roleId) {
            $role = $this->getRoleById($roleId);
            foreach ($validatedData['permission_id'] as $key => $permissionId) {
                $permission = $this->getPermissionById($permissionId);
                if ($role->hasPermissionTo($permission->name)) {
                    $permissions = $role->revokePermissionTo($permission->name);
                }
            }
        }
        return ApiResponse::success(__('messages.assign_role_permission_deleted'),  $permissions ?? '');
    }
    public function getRolePermissions(AssignRolePermissionRequest $request) {}
    public function getPermissionRoles(AssignRolePermissionRequest $request) {}
    public function getUserRolePermissions(AssignRolePermissionRequest $request) {}
}

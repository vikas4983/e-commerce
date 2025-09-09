<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

trait HandlesAuthUser
{
    public function authUser()
    {
        return Auth::guard('sanctum')->user();
    }

    public function authUserId()
    {
        return optional(Auth::guard('sanctum')->user())->id;
    }
    public function getUser($validatedData)
    {
       return User::findOrFail($validatedData['user_id']) ?? __('messages.something_went_wrong');
    }
    public function getPermission($validatedData)
    {
       return Permission::findOrFail($validatedData['user_id']) ?? __('messages.something_went_wrong');
    }
}

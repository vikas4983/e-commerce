<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

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
}

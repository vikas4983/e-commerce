<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::allData()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.role_not_found'), $data);
        }
        return ApiResponse::success(__('messages.role_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {

        $validatedData = $request->validated();
        $data  = Role::create($validatedData);
        return ApiResponse::success(__('messages.role_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Role::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.role_not_found'), $data);
        }
        return ApiResponse::success(__('messages.role_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        $data = Role::id($id)->first();
        $valiodatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.role_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy(string $id)
    {
        $data = Role::find($id);
        if (!$data) {
            return ApiResponse::error(__('messages.role_not_found'));
        }
        $info = $data->only(['id', 'name', 'guard_name']);
        $data->permissions()->detach();
        $data->delete();
        return ApiResponse::success(__('messages.role_deleted'), $info);
    }
}

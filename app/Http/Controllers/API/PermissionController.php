<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Permission::allData()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.permission_not_found'), $data);
        }
        return ApiResponse::success(__('messages.permission_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $validatedData = $request->validated();
        $data  = Permission::create($validatedData);
        return ApiResponse::success(__('messages.permission_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Permission::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.permission_not_found'), $data);
        }
        return ApiResponse::success(__('messages.permission_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, string $id)
    {
        $data = Permission::id($id)->first();
        $valiodatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.permission_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Permission::find($id);
        if (!$data) {
            return ApiResponse::error(__('messages.permission_not_found'));
        }
        $data->permissions()->detach();
        $data->delete();
        return ApiResponse::success(__('messages.permission_deleted'), $data);
    }
}

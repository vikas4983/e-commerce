<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\brand;
use App\Traits\HandlesAuthUser;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use HandlesAuthUser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Brand::alldata()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.brand_not_found'), $data);
        }
        return ApiResponse::success(__('messages.brand_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
         $userId = $this->authUserId();
        if (!$userId) {
            return ApiResponse::error(__('messages.login'), '');
        }
        $validatedData = $request->validated();
        $data  = Brand::create($validatedData);
        return ApiResponse::success(__('messages.brand_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $userId = $this->authUserId();
        if (!$userId) {
            return ApiResponse::error(__('messages.login'), '');
        }
        $data = Brand::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.brand_not_found'), $data);
        }
        return ApiResponse::success(__('messages.brand_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
         $userId = $this->authUserId();
        if (!$userId) {
            return ApiResponse::error(__('messages.login'), '');
        }
        $data = Brand::id($id)->first();
        $valiodatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.brand_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $userId = $this->authUserId();
        if (!$userId) {
            return ApiResponse::error(__('messages.login'), '');
        }
        $data = Brand::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($id);
        return ApiResponse::success(__('messages.brand_deleted'), $data);
    }
}

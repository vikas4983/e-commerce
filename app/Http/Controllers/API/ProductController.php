<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Traits\HandlesAuthUser;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use HandlesAuthUser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::alldata()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.product_not_found'), $data);
        }
        return ApiResponse::success(__('messages.product_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
         $userId = $this->authUserId();
        if (!$userId) {
            return ApiResponse::error(__('messages.login'), '');
        }
        $validatedData = $request->validated();

        $data  = Product::create($validatedData);
        return ApiResponse::success(__('messages.product_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $data = Product::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.product_not_found'), $data);
        }
        return ApiResponse::success(__('messages.product_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
         $userId = $this->authUserId();
        if (!$userId) {
            return ApiResponse::error(__('messages.login'), '');
        }
        $data = Product::id($id)->first();
        $valiodatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.product_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $userId = $this->authUserId();
        if (!$userId) {
            return ApiResponse::error(__('messages.login'), '');
        }
        $data = Product::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($id);
        return ApiResponse::success(__('messages.product_deleted'), $data);
    }
}

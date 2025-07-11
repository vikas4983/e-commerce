<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;
use App\Models\ProductVariant;
use App\Traits\HandlesAuthUser;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{ 
    use HandlesAuthUser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductVariant::allData()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.product_variant_not_found'), $data);
        }
        return ApiResponse::success(__('messages.product_variant_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductVariantRequest $request)
    {
        $userId = $this->authUserid();
        $validatedData = $request->validated();
        if ($userId) {
            $validatedData['user_id'] = $userId;
            $data  = ProductVariant::create($validatedData);
        } else {
            $data  = ProductVariant::create($validatedData);
        }
        return ApiResponse::success(__('messages.product_variant_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ProductVariant::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.product_variant_not_found'), $data);
        }
        return ApiResponse::success(__('messages.product_variant_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductVariantRequest $request, string $id)
    {
        $data = ProductVariant::id($id)->first();
        $valiodatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.product_variant_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ProductVariant::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($id);
        return ApiResponse::success(__('messages.product_variant_deleted'), $data);
    }
}

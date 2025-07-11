<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\CartItem;
use App\Traits\HandlesAuthUser;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    use HandlesAuthUser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CartItem::alldata()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.cart_item_not_found'), $data);
        }
        return ApiResponse::success(__('messages.cart_item_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartItemRequest $request)
    {
        $userId = $this->authUserid();
        $validatedData = $request->validated();
        if ($userId) {
            $validatedData['user_id'] = $userId;
            $data  = CartItem::create($validatedData);
        } else {
            $data  = CartItem::create($validatedData);
        }


        return ApiResponse::success(__('messages.cart_item_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = CartItem::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.cart_item_not_found'), $data);
        }
        return ApiResponse::success(__('messages.cart_item_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemRequest $request, string $id)
    {
        $data = CartItem::id($id)->first();
        $valiodatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.cart_item_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = CartItem::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($id);
        return ApiResponse::success(__('messages.cart_item_deleted'), $data);
    }
}

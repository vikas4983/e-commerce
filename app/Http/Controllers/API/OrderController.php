<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Traits\HandlesAuthUser;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use HandlesAuthUser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = $this->authUserId();
        if (!$userId) {
            return ApiResponse::error(__('messages.login'), '');
        }
        $data = Order::alldata()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.order_not_found'), $data);
        }
        return ApiResponse::success(__('messages.order_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $validatedData = $request->validated();
        $userId = $this->authUserId();
        if ($userId) {
            $validatedData['user_id'] = $userId;
            $data = Order::create($validatedData);
        } else {
            $data = Order::create($validatedData);
        }
        return ApiResponse::success(__('messages.address_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Order::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.order_not_found'), $data);
        }
        return ApiResponse::success(__('messages.order_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $id)
    {
        $userId = $this->authUserId();
        if (!$userId) {
            return ApiResponse::error(__('messages.login'), '');
        }
        $data = Order::id($id)->first();
        $valiodatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.order_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $data = Order::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($id);
        return ApiResponse::success(__('messages.order_deleted'), $data);
    }
}

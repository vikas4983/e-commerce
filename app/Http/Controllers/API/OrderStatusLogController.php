<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderStatusLogRequest;
use App\Http\Requests\UpdateOrderStatusLogRequest;
use App\Models\OrderStatusLog;
use Illuminate\Http\Request;
use App\Traits\HandlesAuthUser;

class OrderStatusLogController extends Controller
{
    use HandlesAuthUser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = OrderStatusLog::allData()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.order_status_log_not_found'), $data);
        }
        return ApiResponse::success(__('messages.order_status_log_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderStatusLogRequest $request)
    {
        $validatedData = $request->validated();
        $exist = OrderStatusLog::existRecord($validatedData)->first();
        $data = OrderStatusLog::updateOrCreate(
            ['order_id' =>  $validatedData['order_id'], 'status_id' => $validatedData['status_id']],
            collect($validatedData)->except(['order_id', 'status_id'])->toArray()
        );
        return ApiResponse::success(__('messages.order_status_log_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = OrderStatusLog::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.order_status_log_not_found'), $data);
        }
        return ApiResponse::success(__('messages.order_status_log_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderStatusLogRequest $request, string $id)
    {
        $data = OrderStatusLog::id($id)->first();
        $valiodatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.order_status_log_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = OrderStatusLog::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($id);
        return ApiResponse::success(__('messages.order_status_log_deleted'), $data);
    }
}

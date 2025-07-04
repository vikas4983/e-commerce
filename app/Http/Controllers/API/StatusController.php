<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Status::allData()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.status_not_found'), $data);
        }
        return ApiResponse::success(__('messages.status_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request)
    {
        $validatedData = $request->validated();
        $data  = Status::create($validatedData);
        return ApiResponse::success(__('messages.status_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Status::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.status_not_found'), $data);
        }
        return ApiResponse::success(__('messages.status_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, string $id)
    {
        $data = Status::id($id)->first();
        $valiodatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.status_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Status::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($id);
        return ApiResponse::success(__('messages.status_deleted'), $data);
    }
}

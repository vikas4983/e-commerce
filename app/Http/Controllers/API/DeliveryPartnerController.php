<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeliveryPartnerRequest;
use App\Http\Requests\UpdateDeliveryPartnerRequest;
use App\Models\DeliveryPartner;
use Illuminate\Http\Request;

class DeliveryPartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DeliveryPartner::allData()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.delivery_partner_not_found'), $data);
        }
        return ApiResponse::success(__('messages.delivery_partner_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeliveryPartnerRequest $request)
    {
        $validatedData = $request->validated();
        $data  = DeliveryPartner::create($validatedData);
        return ApiResponse::success(__('messages.delivery_partner_created'), $data);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DeliveryPartner::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.delivery_partner_not_found'), $data);
        }
        return ApiResponse::success(__('messages.delivery_partner_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeliveryPartnerRequest $request, string $id)
    {
        $data = DeliveryPartner::id($id)->first();
        $valiodatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.delivery_partner_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = DeliveryPartner::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($id);
        return ApiResponse::success(__('messages.delivery_partner_deleted'), $data);
    }
}

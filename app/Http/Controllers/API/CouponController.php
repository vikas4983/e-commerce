<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $data = Coupon::allData()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.coupon_not_found'), $data);
        }
        return ApiResponse::success(__('messages.coupon_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {
        $validatedData = $request->validated();
        $data  = Coupon::create($validatedData);
        return ApiResponse::success(__('messages.coupon_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Coupon::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.coupon_not_found'), $data);
        }
        return ApiResponse::success(__('messages.coupon_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, string $id)
    {
          $data = Coupon::id($id)->first();
        $valiodatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.coupon_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Coupon::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($id);
        return ApiResponse::success(__('messages.coupon_deleted'), $data);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Address::allData()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.address_not_found'), $data);
        }
        return ApiResponse::success(__('messages.address_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $validatedData = $request->validated();
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $userId = $user->id;
            $data = Address::where('user_id', $userId)
                ->where('type', $validatedData['type'])
                ->first();
            if ($data) {
                return ApiResponse::success(__('messages.address_already'), $data);
            }
            $data = Address::updateOrCreate(
                [
                    'user_id' => $userId,
                    'type'    => $validatedData['type'],
                ],
                $validatedData + ['user_id' => $userId]
            );
        } else {
            $guestToken = $validatedData['guest_token'] ?? (string) Str::uuid();
            $data = Address::updateOrCreate(
                [
                    'guest_token' => $guestToken,
                    'type'        => $validatedData['type'],
                ],
                $validatedData + ['guest_token' => $guestToken]
            );
        }
        return ApiResponse::success(__('messages.address_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Address::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.address_not_found'), $data);
        }
        return ApiResponse::success(__('messages.address_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, string $id)
    {
        $data = Address::id($id)->first();
        $valiodatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.address_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Address::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($id);
        return ApiResponse::success(__('messages.address_deleted'), $data);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWishlistRequest;
use App\Http\Requests\UpdateWishlistRequest;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Wishlist::allData()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.wishlist_not_found'), $data);
        }
        return ApiResponse::success(__('messages.wishlist_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWishlistRequest $request)
    {
        $validatedData = $request->validated();
       
        $user = Auth::guard('sanctum')->user();
        $userId = $user->id;
        if (!$user) {
            return ApiResponse::error(__('messages.wishlist_something_went_wrong'), '');
        }
        $data = Wishlist::where('user_id', $userId)->where('product_id', $validatedData['product_id'])->first();
        if ($data) {
            return ApiResponse::already(__('messages.wishlist_already'), $data);
        }
       $data =  Wishlist::updateOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $validatedData['product_id'],
            ],
            [
                'is_active' => $validatedData['is_active']
            ],
            $validatedData + ['user_id' => $userId]
          
        );
        return ApiResponse::success(__('messages.wishlist_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Wishlist::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.wishlist_not_found'), $data);
        }
        return ApiResponse::success(__('messages.wishlist_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWishlistRequest $request, string $id)
    {
        // $user = Auth::guard('sanctum')->user();
        // if (!$user) {
        //     return ApiResponse::error(__('messages.something_went_wrong'), null);
        // }
        // $data = Wishlist::id($id)->first();
        // $valiodatedData = $request->validated();
        // if (!$data) {
        //     return ApiResponse::error(__('messages.something_went_wrong'), $data);
        // }
        
        // $data->update($valiodatedData);
        // return ApiResponse::success(__('messages.wishlist_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Wishlist::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($id);
        return ApiResponse::success(__('messages.wishlist_deleted'), $data);
    }
}

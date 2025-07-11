<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Review::allData()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.review_not_found'), $data);
        }
        return ApiResponse::success(__('messages.review_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $validatedData = $request->validated();
        $user = Auth::guard('sanctum')->user();
        $userId  = $user->id ?? '';
        if (!$user) {
            return ApiResponse::error(__('messages.login'), '');
        }
        $validatedData['user_id'] = $userId;
        $exist = Review::where('user_id', $userId)->where('product_id', $validatedData['product_id'])->first();
        if ($exist) {
            return ApiResponse::already(__('messages.review_already'), '');
        }

        $data  = Review::updateOrCreate(
            [
                'user_id' =>  $userId,
                'product_id' =>  $validatedData['product_id']
            ],
            [
                'rating'     => $validatedData['rating'],
                'comment'    => $validatedData['comment'] ?? null,
                'is_active'  => $validatedData['is_active'],
            ],

        );
        return ApiResponse::success(__('messages.review_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Review::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.review_not_found'), $data);
        }
        return ApiResponse::success(__('messages.review_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, string $id)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return ApiResponse::error(__('messages.login'), '');
        }
        $data = Review::id($id)->first();
        $valiodatedData = $request->validated();

        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($valiodatedData);
        return ApiResponse::success(__('messages.review_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return ApiResponse::error(__('messages.login'), '');
        }
        $data = Review::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($id);
        return ApiResponse::success(__('messages.review_deleted'), $data);
    }
}

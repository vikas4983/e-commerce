<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $data = Category::allData()->latest()->get();
        if (!$data) {
            return ApiResponse::error(__('messages.category_not_found'), $data);
        }
        return ApiResponse::error(__('messages.category_index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();
        $data = Category::create($validatedData);
        return ApiResponse::success(__('messages.category_created'), $data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Category::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.category_not_found'), $data);
        }
        return ApiResponse::success(__('messages.category_show'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request,  $id)
    {
        $data = Category::id($id)->first();
        $validatedData = $request->validated();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->update($validatedData);
        return ApiResponse::success(__('messages.category_update'), $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Category::id($id)->first();
        if (!$data) {
            return ApiResponse::error(__('messages.something_went_wrong'), $data);
        }
        $data->destroy($data->id);
        return ApiResponse::success(__('messages.category_deleted'), $data);
    }
}

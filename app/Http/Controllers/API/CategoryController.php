<?php

namespace App\Http\Controllers\API;

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
        $categories = Category::allData()->latest()->get();
        if (!$categories) {
            return response()->json([
                'status' => 'false',
                'message' => __('messages.category_not_found'),
                'data' => '',
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('messages.category_index'),
            'data' => $categories,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();
        $category = Category::create($validatedData);
        return response()->json([
            'status' => 'success',
            'message' => __('messages.category_created'),
            'data' => $category,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::id($id)->first();
        if (!$category) {
            return response()->json([
                'status' => 'false',
                'message' => __('messages.category_not_found'),
                'data' => null,
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('messages.category_show'),
            'data' => $category,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request,  $id)
    {
        $category = Category::id($id)->first();
        $validatedData = $request->validated();
        if (!$category) {
            return response()->json([
                'status' => 'false',
                'message' => __('messages.something_went_wrong'),
                'data' => '',
            ], 404);
        }
        $category->update($validatedData);
        return response()->json([
            'status' => 'success',
            'message' => __('messages.category_update'),
            'data' => $category,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::id($id)->first();
        if (!$category) {
            return response()->json([
                'status' => 'false',
                'message' => __('messages.category_not_found'),
                'data' => '',
            ], 404);
        }
        $category->destroy($category->id);
        return response()->json([
            'status' => 'success',
            'message' => __('messages.category_deleted'),
            'data' => $category,
        ], 200);
    }
}

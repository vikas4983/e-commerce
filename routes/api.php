<?php

use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CartItemController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DeliveryPartnerController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductVariantController;
use App\Http\Controllers\API\StatusController;
use App\Http\Controllers\API\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Invalid login details'], 401);
    }
    $user = Auth::user();
    return response()->json([
        'message' => 'LOgin successfully',
        'token' => $user->createToken('api-token')->plainTextToken,
        'user' => $user
    ]);
});
Route::post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();
    return response()->json([
        'message' => 'Successfully logged out'
    ]);
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('checkAuth', function () {
    return response()->json([
        'message' => 'You are logged in',
        'user' => Auth::user()
    ]);
});

Route::middleware('set.locale')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('brands', BrandController::class);
    Route::apiResource('productVariants', ProductVariantController::class);
    Route::apiResource('cartItems', CartItemController::class);
    Route::apiResource('statuses', StatusController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('addresses', AddressController::class);
    Route::apiResource('deliveryPartners', DeliveryPartnerController::class);
    Route::apiResource('wishlists', WishlistController::class);
});

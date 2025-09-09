<?php

use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CartItemController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CouponController;
use App\Http\Controllers\API\DeliveryPartnerController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\OrderStatusLogController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductVariantController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\RolePermissionAssignmentController;
use App\Http\Controllers\API\StatusController;
use App\Http\Controllers\API\WishlistController;
use App\Http\Controllers\PaymentController;
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
        'message' => 'Login successfully',
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

Route::middleware(['auth:sanctum', 'set.locale'])->group(function () {


    Route::apiResource('productVariants', ProductVariantController::class);
    Route::apiResource('cartItems', CartItemController::class);
    Route::apiResource('statuses', StatusController::class);
    Route::apiResource('deliveryPartners', DeliveryPartnerController::class);
    Route::apiResource('wishlists', WishlistController::class);
    Route::apiResource('reviews', ReviewController::class);
    Route::apiResource('orderStatusLogs', OrderStatusLogController::class);
    Route::apiResource('coupons', CouponController::class);

    Route::middleware(['role:admin'])->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);
        Route::post('assign-role', [RolePermissionAssignmentController::class, 'assignRoleToUser'])->name('users.assign-role');
        Route::post('revoke-role', [RolePermissionAssignmentController::class, 'revokeRoleFromUser'])->name('users.revoke-role');
        Route::post('assign-permission', [RolePermissionAssignmentController::class, 'assignPermissionToRole'])->name('roles.assign-permissions');
        Route::post('revoke-permission', [RolePermissionAssignmentController::class, 'revokePermissionFromRole'])->name('roles.revoke-permissions');
        Route::get('get-role-permissions', [RolePermissionAssignmentController::class, 'getRolePermissions'])->name('role.permissions');
        Route::get('get-permission-roles', [RolePermissionAssignmentController::class, 'getPermissionRoles'])->name('permission.roles');
        Route::get('users/{uuid}/roles-permissions', [RolePermissionAssignmentController::class, 'getUserRolePermissions'])
            ->name('users.roles.permissions');
    });
});

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('brands', BrandController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('addresses', AddressController::class);



// Route::post('/payu/create',  [PaymentController::class, 'createPayment'])->name('payu.create');
// Route::post('/payu/success', [PaymentController::class, 'success'])->name('payu.success');
// Route::post('/payu/failure', [PaymentController::class, 'failure'])->name('payu.failure');
// Route::post('/payu/webhook', [PaymentController::class, 'webhook'])->name('payu.webhook');

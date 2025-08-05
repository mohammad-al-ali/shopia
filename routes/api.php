<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminApiController;
use App\Http\Controllers\Api\BrandApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\CouponApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\CheckoutApiController;
use App\Http\Controllers\Api\HomeApiController;
use App\Http\Controllers\Api\ShopApiController;
use App\Http\Controllers\Api\SlideApiController;
use App\Http\Middleware\AuthAdminApi;
use App\Http\Controllers\Api\AuthApiController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthApiController::class, 'register']);  // Register
    Route::post('/login', [AuthApiController::class, 'login']); // Login


});
// Home & Shop
Route::get('/home', [HomeApiController::class, 'index']);      // Homepage data (slides + categories)
Route::get('/shop', [ShopApiController::class, 'index']);      // Shop data with filters

// Product details (by slug)
Route::get('/products/{slug}', [ProductApiController::class, 'show']); // Show single product



/*
|--------------------------------------------------------------------------
| Authenticated User Routes (requires Sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Cart operations
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartApiController::class, 'index']);                              // View cart items
        Route::post('/add', [CartApiController::class, 'add']);                            // Add item to cart
        Route::put('/{rowId}/quantity/{action}', [CartApiController::class, 'changeQuantity']); // Change quantity (increase/decrease)
        Route::delete('/{rowId}', [CartApiController::class, 'delete']);                   // Remove single item
        Route::delete('/', [CartApiController::class, 'clear']);                           // Clear cart
    });

    // User Orders
    Route::prefix('user')->group(function () {
        Route::get('/orders', [UserApiController::class, 'orders']); // View user's own orders (web view)
    });

    // Checkout
    Route::get('/checkout', [CheckoutApiController::class, 'show']); // View checkout info

    //AUTH
    Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);  // Logout (requires token)
    Route::get('/profile', [AuthApiController::class, 'getProfile']);    // Get current user profile (requires token)
    });


    });


/*
|--------------------------------------------------------------------------
| Admin Routes (requires Sanctum + AdminAuth Middleware)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', AuthAdminApi::class])
    ->prefix('admin')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminApiController::class, 'index']); // Admin dashboard summary

        // Products (excluding show route)
        Route::apiResource('products', ProductApiController::class)->except(['show']);

        // Product dependency endpoints
        Route::get('create/dependencies', [ProductApiController::class, 'getDependenciesForProductCreating']);   // Get dependencies for product creation
        Route::get('{id}/edit/dependencies', [ProductApiController::class, 'getDependenciesForProductEdit']);    // Get dependencies for product edit

        // Brands (excluding show route)
        Route::apiResource('brands', BrandApiController::class)->except(['show']);

        // Categories (manual routing instead of apiResource)
        Route::get('/category', [CategoryApiController::class, 'index']);            // List categories
        Route::post('/category', [CategoryApiController::class, 'store']);           // Create category
        Route::get('/category/edit/{id}', [CategoryApiController::class, 'edit']);   // Get category for edit
        Route::put('/category/{id}', [CategoryApiController::class, 'update']);      // Update category
        Route::delete('/category{id}', [CategoryApiController::class, 'destroy']);   // Delete category (fix: missing slash)

        // Coupons
        Route::get('/coupons', [CouponApiController::class, 'index']);               // List all coupons
        Route::post('/coupons', [CouponApiController::class, 'store']);              // Create new coupon
        Route::put('/coupons/{id}', [CouponApiController::class, 'update']);         // Update coupon
        Route::patch('/coupons/{id}', [CouponApiController::class, 'update']);       // Alternate update (PATCH)
        Route::delete('/coupons/{id}', [CouponApiController::class, 'destroy']);     // Delete coupon
        Route::post('/coupons/apply', [CouponApiController::class, 'apply']);        // Apply a coupon
        Route::delete('/coupons/remove', [CouponApiController::class, 'remove']);    // Remove applied coupon

        // Order management
        Route::post('/orders/update-status', [OrderApiController::class, 'updateStatus']); // Update order status (admin)
        Route::post('/orders/{id}/cancel', [OrderApiController::class, 'cancel']);         // Cancel order (admin)
        Route::get('/orders', [OrderApiController::class, 'index']);          // List user's orders (paginated)
        Route::get('/orders/{order_id}', [OrderApiController::class, 'show']); // Show specific order details
        Route::post('/orders', [OrderApiController::class, 'store']);         // Create new order
        Route::get('/orders/confirmation', [OrderApiController::class, 'confirmation']); // Order confirmation view (session-based)

// Slides

            Route::get('/slides', [SlideApiController::class, 'index']);          // List all slides (paginated)
            Route::post('/slides', [SlideApiController::class, 'store']);         // Create new slide
            Route::get('/slides/{id}', [SlideApiController::class, 'show']);       // Show specific slide
            Route::put('/slides/{id}', [SlideApiController::class, 'update']);     // Update slide
            Route::delete('/slides/{id}', [SlideApiController::class, 'destroy']); // Delete slide

    });

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'productDetails'])->name('product.details');




Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::put('/cart/increase/{rowId}', [CartController::class, 'increase'])->name('cart.increase');
Route::put('/cart/decrease/{rowId}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::delete('/cart/delete/{rowId}', [CartController::class, 'delete'])->name('cart.delete');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/apply/coupon', [CartController::class, 'applyCoupon'])->name('cart.apply.coupon');
Route::delete('/cart/remove/coupon', [CartController::class, 'removeCoupon'])->name('cart.remove.coupon');

Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');



Route::get('/', [HomeController::class, 'index'])->name('home.index');


Route::middleware(['auth'])->group(function (){

    Route::get('/account.dashboard', [UserController::class, 'index'])->name('user.index');

});
Route::middleware(['auth',AuthAdmin::class])->group(function (){
//BRAND`S ROUTS2
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brand.brands');
    Route::get('/admin/brand/create', [AdminController::class, 'createBrand'])->name('admin.brand.create');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'editBrand'])->name('admin.brand.edit');
    Route::post('/admin/brand/store', [AdminController::class, 'storeBrand'])->name('admin.brand.store');
    Route::put('/admin/brand/update', [AdminController::class, 'updateBrand'])->name('admin.brand.update');
    Route::delete('/admin/brand/delete/{id}', [AdminController::class, 'deleteBrand'])->name('admin.brand.delete');
// bbb
    //CATEGORY`S ROUTS
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.category.categories');
    Route::get('/admin/category/create', [AdminController::class, 'createCategory'])->name('admin.category.create');
    Route::get('/admin/category/edit/{id}', [AdminController::class, 'editCategory'])->name('admin.category.edit');
    Route::post('/admin/category/store', [AdminController::class, 'storeCategory'])->name('admin.category.store');
    Route::put('/admin/category/update', [AdminController::class, 'updateCategory'])->name('admin.category.update');
    Route::delete('/admin/category/delete/{id}', [AdminController::class, 'deleteCategory'])->name('admin.category.delete');

    //PRODUCT`S ROUTS
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.product.products');
    Route::get('/admin/product/create', [AdminController::class, 'createProduct'])->name('admin.product.create');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'editProduct'])->name('admin.product.edit');
    Route::post('/admin/product/store', [AdminController::class, 'storeProduct'])->name('admin.product.store');
    Route::put('/admin/product/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
    Route::delete('/admin/product/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');

    //COUPON ROUTE
    Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupon.coupons');
    Route::get('/admin/coupon/create', [AdminController::class, 'createCoupon'])->name('admin.coupon.create');
    Route::post('/admin/coupon/store', [AdminController::class, 'storeCoupon'])->name('admin.coupon.store');
    Route::get('/admin/coupon/edit/{id}', [AdminController::class, 'editCoupon'])->name('admin.coupon.edit');
    Route::put('/admin/coupon/update', [AdminController::class, 'updateCoupon'])->name('admin.coupon.update');
    Route::delete('/admin/coupon/delete/{id}', [AdminController::class, 'deleteCoupon'])->name('admin.coupon.delete');

});

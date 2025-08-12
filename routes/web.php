<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AI\CustomerChatController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop/{slug}', [ProductController::class, 'show'])->name('product.details');
Route::controller(ShopController::class)->group(function (){
                                  Route::get('/shop', 'index')->name('shop.index');
});
Route::controller(CartController::class)->group(function (){
                                 Route::get('/cart', 'index')->name('cart.index');
                                 Route::post('/cart/add', 'add')->name('cart.add');
                                 Route::put('/cart/change-quantity/{rowId}/{action}','changeQuantity')->name('cart.changeQuantity');
                                 Route::delete('/cart/delete/{rowId}', 'delete')->name('cart.delete');
                                 Route::delete('/cart/clear', 'clear')->name('cart.clear');
});
Route::middleware(['auth'])->group(function (){
                                Route::get('/account.dashboard', [UserController::class, 'index'])->name('user.index');
                                Route::get('/account.orders', [UserController::class, 'orders'])->name('user.account.orders');
                                Route::get('/admin/order/cancel/{id}', [OrderController::class, 'cancel'])->name('admin.order.cancel');
                                Route::post('order/place', [OrderController::class, 'create'])->name('cart.order.place');
                                Route::get('/order/confirmation', [OrderController::class, 'confirmation'])->name('order-confirmation');
                                Route::get('/checkout', [CheckoutController::class,'show'])->name('cart.checkout');
                                Route::post('/cart/apply/coupon', [CouponController::class,'apply'])->name('cart.apply.coupon');
                                Route::delete('/cart/remove/coupon', [CouponController::class,'remove'])->name('cart.remove.coupon');
});
Route::middleware(['auth',AuthAdmin::class])->group(function (){
    Route::controller(AdminController::class)->group(function(){
                                    Route::get('/admin','index')->name('admin.index');
    });
//BRAND`S ROUTS2
    Route::controller(BrandController::class)->group(function(){
                                    Route::get('/brands','brands')->name('admin.brand.brands');
                                    Route::get('/admin/brand/create', 'create')->name('admin.brand.create');
                                    Route::get('/admin/brand/edit/{id}','edit')->name('admin.brand.edit');
                                    Route::post('/brand/store','store')->name('admin.brand.store');
                                    Route::put('/brand/update','update')->name('admin.brand.update');
                                    Route::delete('/brand/delete/{id}','delete')->name('admin.brand.delete');
    });

    //CATEGORY`S ROUTS
    Route::controller(CategoryController::class)->group(function(){
                                     Route::get('/admin/categories','categories')->name('admin.category.categories');
                                     Route::get('/admin/category/create','create')->name('admin.category.create');
                                     Route::get('/admin/category/edit/{id}','edit')->name('admin.category.edit');
                                     Route::post('/admin/category/store','store')->name('admin.category.store');
                                     Route::put('/admin/category/update','update')->name('admin.category.update');
                                     Route::delete('/admin/category/delete/{id}','delete')->name('admin.category.delete');
    });

    //PRODUCT`S ROUTS
    Route::controller(ProductController::class)->group(function(){
                                     Route::get('/admin/products','products')->name('admin.product.products');
                                     Route::get('/admin/product/create','create')->name('admin.product.create');
                                     Route::get('/admin/product/edit/{id}','edit')->name('admin.product.edit');
                                     Route::post('/admin/product/store','store')->name('admin.product.store');
                                     Route::put('/admin/product/update/{id}','update')->name('admin.product.update');
                                     Route::delete('/admin/product/delete/{id}','delete')->name('admin.product.delete');
    });

    //COUPON ROUTE
    Route::controller(CouponController::class)->group(function(){
                                    Route::get('/admin/coupons','coupons')->name('admin.coupon.coupons');
                                    Route::get('/admin/coupon/create','create')->name('admin.coupon.create');
                                    Route::post('/admin/coupon/store','store')->name('admin.coupon.store');
                                    Route::get('/admin/coupon/edit/{id}','edit')->name('admin.coupon.edit');
                                    Route::put('/admin/coupon/update','update')->name('admin.coupon.update');
                                    Route::delete('/admin/coupon/delete/{id}','destroy')->name('admin.coupon.delete');

    });

    //ORDER ROUTE
    Route::controller(OrderController::class)->group(function(){
                                    Route::get('/admin/orders','index')->name('admin.order.orders');
                                    Route::get('/admin/order/{order_id}', 'show')->name('admin.order.show');
                                    Route::put('/admin/order/update', 'updateStatus')->name('admin.order.update');
    });
//SLIDE ROUTE
    Route::controller(SlideController::class)->group(function(){
                                    Route::get('/admin/slides', 'slides')->name('admin.slide.slides');
                                    Route::get('/admin/slide/create', 'create')->name('admin.slide.create');
                                    Route::post('/admin/slide/store', 'store')->name('admin.slide.store');
                                    Route::get('/admin/slide/edit/{id}', 'edit')->name('admin.slide.edit');
                                    Route::put('/admin/slide/update', 'update')->name('admin.slide.update');
                                    Route::delete('/admin/slide/delete/{id}', 'delete')->name('admin.slide.delete');
    });
});
Route::view('/chat', 'chat')->middleware('auth');
Route::get('/chat/history', [CustomerChatController::class, 'getConversationHistory'])->middleware('auth')->name('get.conversation');
Route::post('/chat', [CustomerChatController::class, 'chat'])->name('ai.assistant')->middleware('auth');

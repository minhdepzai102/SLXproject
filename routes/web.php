<?php
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\EditController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\User\ProductShopController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Admin\ShopDetailController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CartController;

use Illuminate\Foundation\Auth\User;

Route::get('admin/users/login', [LoginController::class, 'index'])->name('login');
Route::post('admin/users/login/store', [LoginController::class, 'store']);
Route::get('admin/users/register', [RegisterController::class, 'index'])->name('register');
Route::post('admin/users/register/store', [RegisterController::class, 'store']);
Route::post('admin/users/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('admin');
    Route::get('main', [MainController::class, 'index']);

    # MENU
    Route::prefix('menus')->group(function () {
        Route::get('list', [MenuController::class, 'index'])->name('menus.index'); // Define the index route
        Route::get('add', [MenuController::class, 'create'])->name('menus.add'); // Define the route with a name
        Route::post('store', [MenuController::class, 'store'])->name('menus.store');
        Route::get('edit/{menu}', [MenuController::class, 'edit'])->name('menus.edit');
        Route::post('update/{menu}', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('destroy/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
    });


    #product
    Route::prefix('products')->group(function () {
        Route::get('/products/search', [ProductController::class, 'search']);
        Route::get('list', [ProductController::class, 'index'])->name('products.index');
        Route::get('add', [ProductController::class, 'create'])->name('products.add');
        Route::post('store', [ProductController::class, 'store'])->name('products.store');
        Route::get('edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('update/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('destroy/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/get-child-menus', [ProductController::class, 'getChildMenus'])->name('get.child.menus');
    });


    Route::prefix('edit')->group(function () {
        Route::get('index', [EditController::class, 'index'])->name('edit.index');
        Route::put('/shop-details/edit', [ShopDetailController::class, 'edit'])->name('shop-details.edit');
        Route::post('/shop-details/update', [ShopDetailController::class, 'update'])->name('shop-details.update');
    });
    # SLIDE
    Route::prefix('slides')->group(function () {

        Route::get('index', [SlideController::class, 'index'])->name('slide.index');
        Route::get('add', [SlideController::class, 'create'])->name('slide.add'); // Show form to add a slide
        Route::post('store', [SlideController::class, 'store'])->name('slide.store'); // Store a new slide
        Route::get('edit/{slide}', [SlideController::class, 'edit'])->name('slide.edit'); // Show form to edit a slide
        Route::put('update/{slide}', [SlideController::class, 'update'])->name('slide.update');

        Route::delete('destroy/{slide}', [SlideController::class, 'destroy'])->name('slide.destroy'); // Delete a slide
    });


});

Route::prefix('user')->group(function () {
    Route::get('index', [UserController::class, 'index'])->name('user.index');
    Route::get('shop', [ProductShopController::class, 'index'])->name('user.shop');
    Route::get('shop/category/{category}', [ProductShopController::class, 'filterByCategory'])->name('shop.category');
    Route::get('shop/all', [ProductShopController::class, 'allProducts'])->name('shop.all');
    Route::get('product/{id}', [ProductShopController::class, 'show'])->name('product.single');
    Route::post('logout', [LoginController::class, 'logout'])->name('user.logout');
    Route::post('/products/{productId}/rate', [RatingController::class, 'rate'])->name('products.rate');
    Route::get('api/products/search', [ProductController::class, 'liveSearch'])->name('api.products.search');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

});
Route::post('/chat/send', [MessageController::class, 'sendMessage']);

// Route lấy lịch sử tin nhắn
Route::get('/chat/messages', [MessageController::class, 'getMessages']);



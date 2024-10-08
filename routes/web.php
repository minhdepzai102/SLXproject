
<?php
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\MainController;
use Illuminate\Support\Facades\Route;

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
});

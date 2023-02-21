<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('is_admin')->namespace('Admin')->group(function () {
        Route::get('/order', [OrderController::class, 'index'])->name('home');
    });
});

require __DIR__ . '/auth.php';

/*============================*/

Route::get('/', [MainController::class, 'index'])->name('index');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('get-logout');

Route::prefix('basket')->group(function () {

    Route::match(['get', 'post'], '/add/{id}', [BasketController::class, 'basketAdd'])->name('basket-add');

    Route::middleware('basket_not_empty')->group(function () {
        Route::get('/', [BasketController::class, 'basket'])->name('basket');

        Route::get('/place', [BasketController::class, 'basketPlace'])->name('basket-place');

        Route::post('/place', [BasketController::class, 'basketConfirm'])->name('basket-confirm');
    });

    Route::match(['get', 'post'], '/remove/{id}', [BasketController::class, 'basketRemove'])->name('basket-remove');
});

Route::get('/categories', [MainController::class, 'categories'])->name('categories');

Route::get('/{category}', [MainController::class, 'category'])->name('category');

Route::get('/{category}/{product?}', [MainController::class, 'product'])->name('product');

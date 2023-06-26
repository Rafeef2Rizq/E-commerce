<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LandingPageController::class,'index'])->name('landing-page');
Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
Route::get('/shop/{slug}',[ShopController::class,'show'])->name('shop.show');
Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart',[CartController::class,'store'])->name('cart.store');
Route::delete('/cart/{product}',[CartController::class,'destroy'])->name('cart.destroy');
Route::post('/cart/switchForLater/{product}',[CartController::class,'switchForLater'])->name('cart.switchForLater');
Route::delete('/saveForLater/{product}',[SaveForLaterController::class,'destroy'])->name('saveForLater.destroy');
Route::post('/saveForLater/switchForLater/{product}',[SaveForLaterController::class,'switchToCar'])->
name('saveForLater.switchForLater');
Route::get('/checkout',[CheckoutController::class,'index'])->name('checkout.index');
Route::post('/checkout',[CheckoutController::class,'store'])->name('checkout.store');
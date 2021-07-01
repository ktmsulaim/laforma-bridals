<?php

use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\WebsiteResourceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [WebsiteController::class, 'index'])->name('website.index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Routes for front resources
|--------------------------------------------------------------------------
|
*/

Route::get('/products/featured', [WebsiteResourceController::class, 'featuredProducts'])->name('featuredProducts');
Route::get('/products/{slug}/view', [WebsiteController::class, 'singleProduct'])->name('singleProduct');
Route::get('/products/{product}', [WebsiteController::class, 'product'])->name('products.show');
Route::get('/cart', [WebsiteController::class, 'cart'])->name('cart');
Route::get('/checkout', [WebsiteController::class, 'checkout'])->name('checkout');
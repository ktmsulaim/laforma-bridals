<?php

use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\WebsitePackageController;
use App\Http\Controllers\WebsiteResourceController;
use App\Mail\NewOrderSummaryMail;
use App\Models\Order;
use Illuminate\Support\Facades\Route;


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
| Products
|--------------------------------------------------------------------------
|
*/

Route::get('/products/featured', [WebsiteResourceController::class, 'featuredProducts'])->name('featuredProducts');
Route::get('/products/{slug}/view', [WebsiteController::class, 'singleProduct'])->name('singleProduct');
Route::get('/products/{product}', [WebsiteController::class, 'product'])->name('products.show');
Route::get('/cart', [WebsiteController::class, 'cart'])->name('cart');
Route::get('/checkout', [WebsiteController::class, 'checkout'])->name('checkout');

/*
|--------------------------------------------------------------------------
| Packages
|--------------------------------------------------------------------------
|
*/
Route::get('/packages', [WebsitePackageController::class, 'index'])->name('packages.index');
Route::get('/packages/list', [WebsitePackageController::class, 'list'])->name('packages.list');
Route::get('/packages/{slug}', [WebsitePackageController::class, 'show'])->name('packages.show');
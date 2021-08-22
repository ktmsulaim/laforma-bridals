<?php

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\WebsitePackageController;
use App\Http\Controllers\WebsiteResourceController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\WebsiteGalleryController;
use App\Http\Controllers\WebsiteJobController;
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


/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
|
*/

Route::get('/products', [WebsiteResourceController::class, 'allProducts'])->name('products.index');
Route::get('/products/get', [WebsiteResourceController::class, 'getProducts'])->name('products.get');
Route::get('/products/count/byPrice', [WebsiteResourceController::class, 'getCategoryWiseFilteredProductsCount'])->name('products.count.byPrice');
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
Route::get('/packages/get/{package}', [WebsitePackageController::class, 'get'])->name('packages.get');

Route::post('/packages/{package}/check/availability', [WebsitePackageController::class, 'checkAvailability'])->name('packages.check.availability');

/*
|--------------------------------------------------------------------------
| Reviews
|--------------------------------------------------------------------------
|
*/
Route::post('/captcha/validate', [CaptchaController::class, 'validateCaptcha'])->name('captcha.validate');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/byProduct', [ReviewController::class, 'get'])->name('reviews.get');

/*
|--------------------------------------------------------------------------
| Jobs
|--------------------------------------------------------------------------
|
*/
Route::get('jobs', [WebsiteJobController::class, 'index'])->name('jobs.index');
Route::get('jobs/{slug}', [WebsiteJobController::class, 'show'])->name('jobs.show');

/*
|--------------------------------------------------------------------------
| Collections
|--------------------------------------------------------------------------
|
*/
Route::get('collections/latest', [WebsiteResourceController::class, 'latestCollection'])->name('collections.latest');
Route::get('collections/list', [WebsiteGalleryController::class, 'list'])->name('collections.list');
Route::get('collections/{id}/images', [WebsiteGalleryController::class, 'byCollection'])->name('collections.byCollection');
Route::get('collections/{slug}/view', [WebsiteGalleryController::class, 'show'])->name('collections.show');
Route::get('collections', [WebsiteGalleryController::class, 'index'])->name('collections.index');

/*
|--------------------------------------------------------------------------
| Pages
|--------------------------------------------------------------------------
|
*/


Route::get("/test", function() {
    // dd($_SERVER['SERVER_NAME']);
});
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminCustomersController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\ManageOrders;
use App\Http\Controllers\Admin\TransactionsController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout.post');

Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    /**
     * -------------------------------------------------------------------
     * Customers
     * -------------------------------------------------------------------
     */
    Route::get('customers', [AdminCustomersController::class, 'index'])->name('customers.index');
    Route::get('customers/list', [AdminCustomersController::class, 'listCustomers'])->name('customers.list');
    Route::get('customers/{customer}', [AdminCustomersController::class, 'show'])->name('customers.show');
    Route::patch('customers/{customer}', [AdminCustomersController::class, 'update'])->name('customers.update');

    
     /**
     * -------------------------------------------------------------------
     * Categories
     * -------------------------------------------------------------------
     */
    Route::resource('categories', CategoryController::class);

     /**
     * -------------------------------------------------------------------
     * Tags
     * -------------------------------------------------------------------
     */
    Route::get('/tags', [TagsController::class, 'index'])->name('tags.index');
    Route::get('/tags/list', [TagsController::class, 'getList'])->name('tags.list');
    Route::post('/tags', [TagsController::class, 'store'])->name('tags.store');
    Route::delete('/tags/{tag}', [TagsController::class, 'destroy'])->name('tags.destroy');

    /**
     * -------------------------------------------------------------------
     * Products
     * -------------------------------------------------------------------
     */
    Route::get('/products/list', [ProductController::class, 'listProducts'])->name('products.list');
    Route::resource('products', ProductController::class);
    
    /**
     * -------------------------------------------------------------------
     * Orders
     * -------------------------------------------------------------------
     */
    Route::get('/orders', [ManageOrders::class, 'index'])->name('orders.index');
    Route::get('/orders/list', [ManageOrders::class, 'listOrders'])->name('orders.list');
    Route::post('/orders/{order}/status', [ManageOrders::class, 'status'])->name('orders.status');
    Route::get('/orders/{order}/print', [ManageOrders::class, 'print'])->name('orders.print');
    Route::get('/orders/{order}', [ManageOrders::class, 'show'])->name('orders.show');
    
    /**
     * -------------------------------------------------------------------
     * Transactions
     * -------------------------------------------------------------------
     */
    Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/list', [TransactionsController::class, 'list'])->name('transactions.list');

     /**
     * -------------------------------------------------------------------
     * Packages
     * -------------------------------------------------------------------
     */
    Route::resource('packages', PackageController::class);
    
    
    /**
     * -------------------------------------------------------------------
     * Jobs
     * -------------------------------------------------------------------
     */
    Route::get('jobs/list', [JobController::class, 'listJobs'])->name('jobs.list');
    Route::resource('jobs', JobController::class);

   
   
    /**
     * -------------------------------------------------------------------
     * File manager
     * -------------------------------------------------------------------
     */
    Route::get('media', [ImageController::class, 'media'])->name('media');
    Route::get('images/list', [ImageController::class, 'listImages'])->name('images.list');
    Route::get('images', [ImageController::class, 'index'])->name('images.index');
    Route::post('images', [ImageController::class, 'store'])->name('images.store');
    Route::delete('images', [ImageController::class, 'destroy'])->name('images.destroy');
});
<?php

use App\Http\Controllers\Customer\Auth\LoginController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\WebsitePackageController;
use Illuminate\Support\Facades\Route;

// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::post('logout', 'Auth\LoginController@logout')->name('logout.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Register
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register.post');

// Reset Password
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Confirm Password
// Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
// Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm')->name('password.confirm.post');


// Verify Email
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('inactive', [LoginController::class, 'inactive'])->name('inactive');

/**
 * ---------------------------------------------------------------------
 * Account
 * ---------------------------------------------------------------------
 */
Route::middleware(['customer.auth', 'customer.verified', 'customer.active'])->group(function(){
    Route::get('dashboard', [CustomerController::class, 'index'])->name('dashboard');

    Route::post('placeorder', [OrderController::class, 'placeorder'])->name('placeorder');
    Route::post('placeorder/nextid', [OrderController::class, 'getNextOrderId'])->name('placeorder.nextid');
    Route::post('payment/getOrder/{type}', [RazorpayController::class, 'getOrderId'])->name('payment.razorpay.getOrder');
    Route::post('payment/makePayment', [RazorpayController::class, 'makePayment'])->name('payment.razorpay.makePayment');

    Route::post('book', [WebsitePackageController::class, 'book'])->name('book');
    Route::post('book/payment', [RazorpayController::class, 'makeBookingPayment'])->name('book.payment');
    Route::post('book/change', [BookingController::class, 'changeTime'])->name('book.change');
    Route::post('book/cancel/{booking}', [BookingController::class, 'cancel'])->name('book.cancel');

    Route::get('orders', [CustomerController::class, 'orders'])->name('orders');
    Route::get('orders/list', [OrderController::class, 'listOrders'])->name('orders.list');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    Route::get('bookings', [CustomerController::class, 'bookings'])->name('bookings');
    Route::get('bookings/list', [BookingController::class, 'list'])->name('bookings.list');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');


    Route::get('account', [CustomerController::class, 'account'])->name('account');
    Route::get('wishlist', [CustomerController::class, 'wishlist'])->name('wishlist');
    Route::get('reviews', [CustomerController::class, 'reviews'])->name('reviews');

    Route::post('products/getMaxQuantity', [OrderController::class, 'getMaxQuantity'])->name('max.quantity');

    Route::resources([
        'address' => AddressController::class,
    ]);
});

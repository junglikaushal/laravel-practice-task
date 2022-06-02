<?php

use Illuminate\Support\Facades\Route;

// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Register
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Reset Password
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Confirm Password
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

// Verify Email
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
// Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::group(['middleware' => ['user.auth:user']], function(){
    
    // Dashboard
    Route::get('/', 'ProductController@index')->name('home');
    
    // Cart
    Route::get('/cart', 'CartController@index')->name('cart');
    Route::post('/addToCart', 'CartController@addTocart')->name('addTocart'); // Add product in cart
    Route::post('/deleteFromCart', 'CartController@deleteFromCart')->name('deleteFromCart'); // Delete product from cart
    Route::post('/qtyUpdate', 'CartController@qtyUpdate')->name('qtyUpdate'); // Update cart product quantity
    Route::post('/checkStock', 'CartController@checkStock')->name('checkStock'); // Check cart product's stock
    Route::get('/payment', 'CheckoutController@index')->name('payment'); // Stripe Card Page
    Route::get('/setup-complete', 'CheckoutController@setupComplete')->name('setup-complete'); // Store stripe card
    Route::get('/checkOut', 'CheckoutController@checkOut')->name('checkOut'); // Store order in database
});
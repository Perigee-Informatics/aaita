<?php

/*
|--------------------------------------------------------------------------
| Backpack\Base Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\Base package.
|
*/
//custom routes for login and logout override
Route::group(
    [
        'namespace'  => 'App\Http\Controllers\Auth',
        'middleware' => 'web',
        'prefix'     => config('backpack.base.route_prefix'),
    ],
    function () {
        Route::get('login', 'LoginController@showLoginForm')->name('backpack.auth.login');
        Route::get('logout', 'LoginController@logout')->name('backpack.auth.logout');


        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout');

        // Registration Routes...
        Route::get('register', 'RegisterController@showRegistrationForm')->name('backpack.auth.register');
        Route::post('register', 'RegisterController@register');

     });

Route::group(
[
    'namespace'  => 'App\Http\Controllers\Auth',
    'middleware' => 'web',
    'prefix'     => config('backpack.base.route_prefix'),
],
    function () {  
        Route::get('dashboard', 'AdminController@dashboard')->name('backpack.dashboard');
        Route::get('/', 'AdminController@redirect')->name('backpack');
    
    });


Route::group(
[
    'namespace'  => 'Backpack\CRUD\app\Http\Controllers',
    'middleware' => 'web',
    'prefix'     => config('backpack.base.route_prefix'),
],
function () {
    // if not otherwise configured, setup the auth routes
    if (config('backpack.base.setup_auth_routes')) {
        // Password Reset Routes...
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('backpack.auth.password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('backpack.auth.password.reset.token');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('backpack.auth.password.email');
    }


    // if not otherwise configured, setup the "my account" routes
    if (config('backpack.base.setup_my_account_routes')) {
        Route::get('edit-account-info', 'MyAccountController@getAccountInfoForm')->name('backpack.account.info');
        Route::post('edit-account-info', 'MyAccountController@postAccountInfoForm');
        Route::post('change-password', 'MyAccountController@postChangePasswordForm')->name('backpack.account.password');
    }
});

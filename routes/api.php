<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
// User API
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Admin API
Route::prefix('admin')->group(function () {
    Route::get('/login', 'API\AdminApiController@login')->name('api.admin.login');
    Route::post('/register', 'API\AdminApiController@register')->name('api.admin.register');
    // admin-api guard
    Route::middleware('auth:admin-api')->group(function () {
        Route::get('/logout', 'API\AdminApiController@logout')->name('api.admin.logout');
        Route::get('/details', 'API\AdminApiController@details')->name('api.admin.details');
        Route::get('/', function (Request $request) {
            return $request->user();
        });
    });
});

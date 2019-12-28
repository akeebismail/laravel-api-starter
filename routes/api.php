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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function (){
    Route::post('register', "RegisterController@register");
    Route::get('resend/{id}/email', 'RegisterController@resendVerificationEmail');
    Route::get('verify/{code}/email', 'RegisterController@verifyEmail');
    Route::post('login','LoginController@login');
    Route::group(['middleware' => 'auth:api'], function (){
        Route::get('refresh', 'LoginController@refresh');
        Route::post('logout','LoginController@logout');
        Route::get('me', 'LoginController@me');
        Route::post('change-password', 'LoginController@changePassword');
    });
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => ['jwt.verify'], 'namespace' => 'API'], function() {

    Route::get('user', 'UserController@getAuthenticatedUser');

});    

Route::group(['namespace' => 'API'], function() {
   
    Route::post('/register', 'UserController@register');
    Route::post('/authenticate', 'UserController@authenticate');

});    


Route::group(['middleware' => 'auth:api'], function() {
    # Auth Routes
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::get('product/search-my-store', [ProductController::class, 'searchMyStore']);
    # Product Routes
    Route::resource('products', ProductController::class);

});
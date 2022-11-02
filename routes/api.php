<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
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
Route::controller(AuthController::class)->group(function (){
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::group(['middleware' => ['auth:api']], function (){
    Route::controller(ProductController::class)->group(function (){
        Route::post('products/store', 'store');
    });
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\FAQController;
use App\Http\Controllers\API\AuthController;

Route::get('banners', [BannerController::class, 'index']);
Route::get('faq', [FAQController::class, 'index']);
Route::post('login', [AuthController::class, 'login']);

Route::get('client/profile', [AuthController::class, 'profile']);
Route::post('client/change-password', [AuthController::class, 'changePassword']);


Route::group(['middleware' => ['auth:clients']], function(){
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\FAQController;
use App\Http\Controllers\API\CatalogueController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EstateController;
use App\Http\Controllers\API\ContactController;

Route::get('banners', [BannerController::class, 'index']);
Route::get('catalogues', [CatalogueController::class, 'index']);
Route::get('faq', [FAQController::class, 'index']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);


Route::get('client/profile', [AuthController::class, 'profile']);
Route::post('client/change-password', [AuthController::class, 'changePassword']);
Route::post('client/update', [AuthController::class, 'update']);

Route::get('client/new-contact', [ContactController::class, 'newContact']);
Route::get('client/list-contact', [ContactController::class, 'listContact']);
Route::get('client/list-contact-detail/{id}', [ContactController::class, 'listContactDetail']);
Route::post('client/create-contact', [ContactController::class, 'createContact']);
Route::post('client/create-contact-detail', [ContactController::class, 'createContactDetail']);

Route::group(['middleware' => ['auth:clients']], function(){
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix' => 'estate', 'as' => 'estate.'], function(){
    /**
     *  Example: id_client = 66
     */
    Route::get('/view_estate/{id_client}', [EstateController::class, 'get_estate']);
    Route::get('/view_schedule/{id_client}', [EstateController::class, 'get_schedule']);
    Route::get('/view_docs/{id_client}', [EstateController::class, 'get_document']);
})->name('estate');
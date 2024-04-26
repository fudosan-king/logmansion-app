<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EstatesController; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::group(['middleware' => ['auth', 'permission']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');    

    Route::group(['prefix'=> 'users', 'as' => 'users.'], function(){
        Route::resource('permissions', PermissionsController::class);
        Route::resource('roles', RolesController::class);
    });    
    Route::resource('users', UsersController::class);
    
  
    Route::group(['prefix'=> 'estates', 'as' => 'estates.'], function(){
      
    });    
    Route::resource('estates', EstatesController::class);

    Route::get('test', function(){
        return "Permission Test with Sidebar";
    })->name('test');
    Route::get('test/aaa', function(){
        return "AAAAAAAA Permission Test with Sidebar";
    })->name('test');

    Route::get('test2', function(){
        return "Permission Test with Sidebar2";
    })->name('test2');
    Route::get('test3', function(){
        return "Route for superuser without assigning";
    })->name('test3');
});
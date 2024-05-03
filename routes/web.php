<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EstatesController; 
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\FAQController;
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

// Route::get('/schedule', function () {
//     return view('schedule.schedule');
// });

Auth::routes();

Route::group(['middleware' => ['auth', 'permission']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');   
      
    Route::get('/notification', [NotificationController::class, 'index'])->name('notification'); 
    Route::get('/notification/create', [NotificationController::class, 'create'])->name('notification.create'); 
    Route::post('/notification/store', [NotificationController::class, 'store'])->name('notification.store');
    Route::get('/notification/edit/{id}', [NotificationController::class, 'edit'])->name('notification.edit');
    Route::put('/notification/update/{id}', [NotificationController::class, 'update'])->name('notification.update');Route::delete('/notifications/destroy/{id}', [NotificationController::class, 'destroy'])->name('notification.destroy');

    Route::get('/topic', [NotificationController::class, 'topicIndex'])->name('topic'); 
    Route::get('/topic/create', [NotificationController::class, 'topicCreate'])->name('topic.create'); 
    Route::post('/topic/store', [NotificationController::class, 'topicStore'])->name('topic.store');
    Route::get('/topic/edit/{id}', [NotificationController::class, 'topicEdit'])->name('topic.edit');
    Route::put('/topic/update/{id}', [NotificationController::class, 'topicUpdate'])->name('topic.update');
    Route::delete('/topic/destroy/{id}', [NotificationController::class, 'topicDestroy'])->name('topic.destroy');
      
    Route::get('/banner', [BannerController::class, 'index'])->name('banner'); 
    Route::get('/banner/create', [BannerController::class, 'create'])->name('banner.create'); 
    Route::post('/banner/store', [BannerController::class, 'store'])->name('banner.store');
    Route::get('/banner/edit/{id}', [BannerController::class, 'edit'])->name('banner.edit');
    Route::put('/banner/update/{id}', [BannerController::class, 'update'])->name('banner.update');
    Route::delete('/banner/destroy/{id}', [BannerController::class, 'destroy'])->name('banner.destroy');
      
    Route::get('/faq', [FAQController::class, 'index'])->name('faq'); 
    Route::get('/faq/create', [FAQController::class, 'create'])->name('faq.create'); 
    Route::post('/faq/store', [FAQController::class, 'store'])->name('faq.store');
    Route::get('/faq/edit/{id}', [FAQController::class, 'edit'])->name('faq.edit');
    Route::put('/faq/update/{id}', [FAQController::class, 'update'])->name('faq.update');
    Route::delete('/faq/destroy/{id}', [FAQController::class, 'destroy'])->name('faq.destroy');
    

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


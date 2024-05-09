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
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\EstContactController;
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

// Route::get('/schedule', function () {`
//     return view('schedule.schedule');
// });

Auth::routes();

Route::group(['middleware' => ['auth', 'permission']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');   
    
    Route::group(['prefix' => 'notification', 'as' => 'notification.'], function(){
        Route::get('/', [NotificationController::class, 'index'])->name('index'); 
        Route::get('/create', [NotificationController::class, 'create'])->name('create'); 
        Route::post('/store', [NotificationController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [NotificationController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [NotificationController::class, 'update'])->name('update');
        Route::delete('/notifications/destroy/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    })->name('notification');;

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
    
    Route::group(['prefix' => 'estate', 'as' => 'estate.'], function(){
        Route::get('/', [EstatesController::class, 'index'])->name('index');
        Route::get('/create', [EstatesController::class, 'create'])->name('create');
        Route::post('/store', [EstatesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [EstatesController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [EstatesController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [EstatesController::class, 'destroy'])->name('destroy');
    })->name('estate');
       

    Route::get('/estate/schedule/{id}', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::post('/estate/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::post('/estate/schedule/update', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/estate/schedule/destroy/{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');

    Route::get('/catalogue', [CatalogueController::class, 'index'])->name('catalogue'); 
    Route::get('/catalogue/create', [CatalogueController::class, 'create'])->name('catalogue.create'); 
    Route::post('/catalogue/store', [CatalogueController::class, 'store'])->name('catalogue.store');
    Route::get('/catalogue/edit/{id}', [CatalogueController::class, 'edit'])->name('catalogue.edit');
    Route::put('/catalogue/update/{id}', [CatalogueController::class, 'update'])->name('catalogue.update');
    Route::delete('/catalogue/destroy/{id}', [CatalogueController::class, 'destroy'])->name('catalogue.destroy'); 
    
    Route::get('/estcontact', [EstContactController::class, 'index'])->name('estcontact'); 
    Route::get('/estcontact/create', [EstContactController::class, 'create'])->name('estcontact.create'); 
    Route::post('/estcontact/store', [EstContactController::class, 'store'])->name('estcontact.store');
    Route::get('/estcontact/edit/{id}', [EstContactController::class, 'edit'])->name('estcontact.edit');
    Route::put('/estcontact/update/{id}', [EstContactController::class, 'update'])->name('estcontact.update');
    Route::delete('/estcontact/destroy/{id}', [EstContactController::class, 'destroy'])->name('estcontact.destroy'); 
});


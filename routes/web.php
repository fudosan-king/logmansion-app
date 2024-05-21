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
use App\Http\Controllers\TopicController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\EstContactController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ClientController;
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
    Route::get('test', function(){
        return view('test');
    });

Auth::routes();

Route::group(['middleware' => ['auth', 'permission']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');   
      
    Route::resource('notification', NotificationController::class);

    Route::resource('topic', TopicController::class);
      
    Route::resource('banner', BannerController::class);
      
    Route::resource('faq', FAQController::class);
    

    Route::group(['prefix'=> 'users', 'as' => 'users.'], function(){
        Route::resource('permissions', PermissionsController::class);
        Route::resource('roles', RolesController::class);
    });    
    Route::resource('users', UsersController::class);
    
    Route::group(['prefix' => 'estate', 'as' => 'estate.'], function(){
        Route::get('/', [EstatesController::class, 'index'])->name('index');
        Route::get('/archive', [EstatesController::class, 'archive_index'])->name('archive_index');
        Route::get('/create', [EstatesController::class, 'create'])->name('create');
        Route::post('/store', [EstatesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [EstatesController::class, 'edit'])->name('edit');
        Route::get('/view/{id}', [EstatesController::class, 'show'])->name('view');
        Route::put('/update/{id}', [EstatesController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [EstatesController::class, 'destroy'])->name('destroy');
        Route::get('/getEstateSchedules/{id}',[EstatesController::class, 'getEstateSchedules'])->name('getEstateSchedules');
    })->name('estate');

    Route::group(['prefix' => 'client', 'as' => 'client.'], function(){
        Route::get('/create/{estate_id}', [ClientController::class, 'create'])->name('create');
        Route::post('/store', [ClientController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ClientController::class, 'update'])->name('update');
        Route::get('/view/{id}', [ClientController::class, 'show'])->name('view');
        Route::delete('/destroy/{id}', [ClientController::class, 'destroy'])->name('destroy');
    });

    Route::get('/estate/schedule/{id}', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::post('/estate/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::post('/estate/schedule/update', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/estate/schedule/destroy/{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');

    Route::get('/estate/doc/{id}', [DocumentController::class, 'edit'])->name('doc.edit');
    Route::post('/estate/doc/store', [DocumentController::class, 'store'])->name('doc.store');
    Route::post('/estate/doc/permanent', [DocumentController::class, 'docPermanent'])->name('doc.permanent');
    Route::post('/estate/doc/update', [DocumentController::class, 'update'])->name('doc.update');
    Route::delete('/estate/doc/destroy/{id}', [DocumentController::class, 'destroy'])->name('doc.destroy');

    Route::get('/catalogue', [CatalogueController::class, 'index'])->name('catalogue'); 
    Route::get('/catalogue/create', [CatalogueController::class, 'create'])->name('catalogue.create'); 
    Route::post('/catalogue/store', [CatalogueController::class, 'store'])->name('catalogue.store');
    Route::get('/catalogue/edit/{id}', [CatalogueController::class, 'edit'])->name('catalogue.edit');
    Route::put('/catalogue/update/{id}', [CatalogueController::class, 'update'])->name('catalogue.update');
    Route::delete('/catalogue/destroy/{id}', [CatalogueController::class, 'destroy'])->name('catalogue.destroy'); 
    
    // Route::get('/estcontact/create', [EstContactController::class, 'create'])->name('estcontact.create'); 
    // Route::post('/estcontact/store', [EstContactController::class, 'store'])->name('estcontact.store');
    // Route::delete('/estcontact/destroy/{id}', [EstContactController::class, 'destroy'])->name('estcontact.destroy'); 
    Route::get('/getDocSearch', [EstContactController::class, 'getDocSearch'])->name('estcontact.getDocSearch');
    Route::get('/estcontact', [EstContactController::class, 'index'])->name('estcontact'); 
    Route::get('/estcontact/edit/{id}', [EstContactController::class, 'edit'])->name('estcontact.edit');
    Route::put('/estcontact/update/{id}', [EstContactController::class, 'update'])->name('estcontact.update');
});


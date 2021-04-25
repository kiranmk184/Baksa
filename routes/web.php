<?php

use Illuminate\Support\Facades\Route;

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
    return view('layouts.app');
});

Route::get('/login',[App\Http\Controllers\AdminController::class,'login'])->name('login');

Route::prefix('/admin')->namespace('Admin')->group(function(){
    //All Admin Routes

    //Authenticate Routes
    Route::group(['middleware' => ['auth:admin']], function () {

    Route::get('/',[App\Http\Controllers\AdminController::class,'show'])->name('index');

    Route::get('/categories',[App\Http\Controllers\CategoryController::class,'index'])->name('admin.categories.index');

    Route::get('/settings',[App\Http\Controllers\SettingController::class,'index'])->name('admin.settings');

    Route::post('/settings',[App\Http\Controllers\SettingController::class,'update'])->name('admin.settings.update');
    });

    Route::get('/login',[App\Http\Controllers\AdminController::class,'create'])->name('admin.create');

    Route::post('/login',[App\Http\Controllers\AdminController::class,'login'])->name('admin.login');

    // Route::get('/login',[App\Http\Controllers\LoginController::class,'show'])->name('admin.login');

    // Route::post('/login',[App\Http\Controllers\LoginController::class,'login'])->name('admin.login.post');

    // Route::get('/logout',[App\Http\Controllers\LoginController::class,'logout'])->name('admin.logout');

});

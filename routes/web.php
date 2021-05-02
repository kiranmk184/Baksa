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
Route::get('login', function () {
    return view('layouts.app');
})->name('login');

Route::get('/', function () {
    return view('layouts.app');
});

//Admin Routes
Route::group(['prefix' => 'admin'], function() {
    Route::get('login', [App\Http\Controllers\LoginController::class,'loginForm'])->name('admin.login');
    Route::post('login', [App\Http\Controllers\LoginController::class,'login'])->name('admin.login.post');
    Route::get('logout', [\App\Http\Controllers\LoginController::class,'logout'])->name('admin.logout');

    Route::group(['middleware' => ['auth:admin']], function() {
        Route::get('/', function () {
            return view('admin.layouts.app');
        })->name('admin.index');
    });

    Route::group(['prefix' => 'categories'], function() {
        Route::get('/', [App\Http\Controllers\CategoryController::class,'index'])->name('admin.categories.index');
        Route::get('/create', [App\Http\Controllers\CategoryController::class,'create'])->name('admin.categories.create');
        Route::post('/store', [App\Http\Controllers\CategoryController::class,'store'])->name('admin.categories.store');
        Route::get('/{id}/edit', [App\Http\Controllers\CategoryController::class,'edit'])->name('admin.categories.edit');
        Route::post('/update', [App\Http\Controllers\CategoryController::class,'update'])->name('admin.categories.update');
        Route::get('/{id}/delete', [App\Http\Controllers\CategoryController::class,'delete']   )->name('admin.categories.delete');
    });

    Route::group(['prefix' => 'attributes'], function() {
        Route::get('/', [App\Http\Controllers\AttributeController::class,'index'])->name('admin.attributes.index');
        Route::get('/create', [App\Http\Controllers\AttributeController::class,'create'])->name('admin.attributes.create');
        Route::get('/store', [App\Http\Controllers\AttributeController::class,'store'])->name('admin.attributes.store');
        Route::get('/{id}/edit', [App\Http\Controllers\AttributeController::class,'edit'])->name('admin.attributes.edit');
        Route::get('/update', [App\Http\Controllers\AttributeController::class,'update'])->name('admin.attributes.update');
        Route::get('/{id}/delete', [App\Http\Controllers\AttributeController::class,'delete'])->name('admin.attributes.delete');
    });

    Route::group(['prefix' => 'brands'], function(){
        Route::get('/', [App\Http\Controllers\BrandController::class,'index'])->name('admin.brands.index');
        Route::get('/create', [App\Http\Controllers\BrandController::class,'create'])->name('admin.brands.create');
        Route::get('/store', [App\Http\Controllers\BrandController::class,'strore'])->name('admin.brands.store');
        Route::get('/{id}/edit', [App\Http\Controllers\BrandController::class,'edit'])->name('admin.brands.edit');
        Route::get('/update', [App\Http\Controllers\BrandController::class,'update'])->name('admin.brands.update');
        Route::get('/{id}/delete', [App\Http\Controllers\BrandController::class,'delete'])->name('admin.brands.delete');
    });

    Route::group(['prefix' => 'products'], function(){
        Route::get('/', [App\Http\Controllers\ProductController::class,'index'])->name('admin.products.index');
        Route::get('/create', [App\Http\Controllers\ProductController::class,'create'])->name('admin.products.create');
        Route::get('/store', [App\Http\Controllers\ProductController::class,'strore'])->name('admin.products.store');
        Route::get('/{id}/edit', [App\Http\Controllers\ProductController::class,'edit'])->name('admin.products.edit');
        Route::get('/update', [App\Http\Controllers\ProductController::class,'update'])->name('admin.products.update');
        Route::get('/{id}/delete', [App\Http\Controllers\ProductController::class,'delete'])->name('admin.products.delete');

        Route::post('images/upload', [App\Http\Controllers\ProductImageController::class,'upload'])->name('admin.products.images.upload');
        Route::get('images/{id}/delete', [App\Http\Controllers\ProductImageController::class,'delete'])->name('admin.products.images.delete');

        // Load attributes on the page load
        Route::get('attributes/load', [App\Http\Controllers\ProductAttributeController::class,'loadAttributes']);
        // Load product attributes on the page load
        Route::post('attributes', [App\Http\Controllers\ProductAttributeController::class,'productAttributes']);
        // Load option values for a attribute
        Route::post('attributes/values', [App\Http\Controllers\ProductAttributeController::class,'loadValues']);
        // Add product attribute to the current product
        Route::post('attributes/add', [App\Http\Controllers\ProductAttributeController::class,'addAttribute']);
        // Delete product attribute from the current product
        Route::post('attributes/delete', [App\Http\Controllers\ProductAttributeController::class,'deleteAttribute']);
    });
});

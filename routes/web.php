<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\POIController;
use App\Http\Controllers\DaerahController;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () { 
    Route::controller(HomeController::class)->group(function () {
        Route::match(['GET', 'POST'], '/', 'index')->name('home');
        Route::prefix('artikel')->group(function (){
            Route::match(['GET'], '/', 'artikelHome')->name('artikel.home');
            Route::match(['GET'], '/post/{id}', 'artikelSingleHome')->name('artikel.single.home');
            Route::match(['GET'], '/category/{id}', 'artikelCategoryHome')->name('artikel.category.home');
        });
        Route::prefix('peta')->group(function (){
            Route::match(['GET'], '/resiko', 'peta')->name('peta');
            Route::match(['GET'], '/resiko/map', 'petaResiko')->name('petaResiko');
        });
    });
    Route::controller(AuthController::class)->group(function () {
        Route::match(['GET', 'POST'], '/login', 'index')->name('login');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->group(function () { 
        Route::controller(AuthController::class)->group(function () {
            Route::match(['GET'], '/logout', 'logout')->name('logout');
        });
        Route::controller(DashboardController::class)->group(function () {
            Route::match(['GET', 'POST'], '/', 'index')->name('dashboard');
        });
        Route::controller(ArtikelController::class)->group(function () {
            Route::prefix('artikel')->group(function (){
                Route::match(['GET','POST'], '/', 'artikel')->name('artikel');
                Route::match(['GET','POST'], '/update/{id}', 'artikelSingle')->name('artikel.single');
                Route::match(['GET'], '/delete/{id}', 'artikelDelete')->name('artikel.delete');
                Route::prefix('category')->group(function (){
                    Route::match(['GET','POST'], '/', 'artikelCategory')->name('artikel.category');
                    Route::match(['GET','POST'], '/update/{id}', 'artikelCategorySingle')->name('artikel.category.single');
                    Route::match(['GET'], '/delete/{id}', 'artikelCategoryDelete')->name('artikel.category.delete');
                });
            });
        });
        Route::controller(KasusController::class)->group(function () {
            Route::prefix('kasus')->group(function (){
                Route::match(['GET','POST'], '/', 'kasus')->name('kasus');
                Route::match(['GET','POST'], '/update/{id}', 'kasusSingle')->name('kasus.single');
                Route::match(['GET'], '/delete/{id}', 'kasusDelete')->name('kasus.delete');
                Route::prefix('category')->group(function (){
                    Route::match(['GET','POST'], '/', 'kasusCategory')->name('kasus.category');
                    Route::match(['GET','POST'], '/update/{id}', 'kasusCategorySingle')->name('kasus.category.single');
                    Route::match(['GET'], '/delete/{id}', 'kasusCategoryDelete')->name('kasus.category.delete');
                });
            });
        });
        Route::controller(POIController::class)->group(function () {
            Route::prefix('poi')->group(function (){
                Route::match(['GET','POST'], '/', 'poi')->name('poi');
                Route::match(['GET','POST'], '/update/{id}', 'poiSingle')->name('poi.single');
                Route::match(['GET'], '/delete/{id}', 'poiDelete')->name('poi.delete');
                Route::prefix('category')->group(function (){
                    Route::match(['GET','POST'], '/', 'poiCategory')->name('poi.category');
                    Route::match(['GET','POST'], '/update/{id}', 'poiCategorySingle')->name('poi.category.single');
                    Route::match(['GET'], '/delete/{id}', 'poiCategoryDelete')->name('poi.category.delete');
                });
            });
        });
        Route::controller(DaerahController::class)->group(function () {
            Route::prefix('daerah')->group(function (){
                Route::match(['GET','POST'], '/', 'daerah')->name('daerah');
                Route::match(['GET','POST'], '/update/{id}', 'daerahSingle')->name('daerah.single');
                Route::match(['GET'], '/delete/{id}', 'daerahDelete')->name('daerah.delete');
            });
        });
        Route::controller(UserController::class)->group(function () {
            Route::prefix('user')->group(function (){
                Route::match(['GET','POST'], '/', 'index')->name('user');
                Route::match(['GET','POST'], '/update/{id}', 'show')->name('user.show');
                Route::match(['GET'], '/delete/{id}', 'destroy')->name('user.delete');
            });
        });
    });
});
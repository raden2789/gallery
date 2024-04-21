<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/image-store', [App\Http\Controllers\ImageController::class, 'storeImage'])->name('image-store');
Route::post('/hapus/{id}', [App\Http\Controllers\ImageController::class, 'deleteimage'])->name('hapus');

// album
Route::get('/buat-album', [App\Http\Controllers\AlbumController::class, 'index'])->name('buat-album');
Route::post('/album-store', [App\Http\Controllers\AlbumController::class, 'storealbum'])->name('album-store');
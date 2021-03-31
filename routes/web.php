<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;

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

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

Route::any('/', [App\Http\Controllers\UrlController::class, 'index'])->name('url.index');
Route::get('/get-urls', [App\Http\Controllers\UrlController::class, 'get'])->name('url.get');
Route::post('/click-track', [App\Http\Controllers\UrlController::class, 'track'])->name('url.track');

Route::get('{short_url}', [App\Http\Controllers\UrlController::class, 'shortUrl'])->name('short.url');

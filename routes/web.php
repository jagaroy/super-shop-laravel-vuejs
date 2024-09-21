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

// Solution for Invalid characters passed for attempted conversion, these have been ignored
// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
// error_reporting(E_ALL ^ (E_DEPRECATED));
// Route::get('/clear_all_cache', function () {
//     Artisan::call('view:clear'); Artisan::call('config:cache'); Artisan::call('config:clear'); Artisan::call('cache:clear'); Artisan::call('route:clear'); Artisan::call('key:generate');
//     return 'All caches are cleared!';
// })->name('allClear');

Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*');

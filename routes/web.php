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

Auth::routes();

Route::group(['middleware' => 'auth'], function() {

Route::resource('/items', App\Http\Controllers\ItemController::class)->only(['index', 'show','create','store']);
Route::resource('/bid-logs', App\Http\Controllers\BidLogController::class)->only(['store', 'index']);
Route::resource('/settings', App\Http\Controllers\SettingController::class)->only(['create', 'store']);

//apis
Route::post('/api/set-auto-bid', [App\Http\Controllers\ItemController::class,'setAutoBid'])->name('api.set-auto-bid');
Route::post('/api/search-items', [App\Http\Controllers\ItemController::class,'searchItems'])->name('api.search-items');

// user management
Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::get('/', function () {
    return view('auth/login');
});


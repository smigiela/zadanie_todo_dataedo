<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('about', 'about')->name('about')->middleware('auth');

Route::group(['middleware' => 'auth'], function() {
    Route::resource('todo', TodoController::class)->except(['show', 'create']);
});

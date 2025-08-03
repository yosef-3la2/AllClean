<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

//for islocked
Route::middleware(['islocked'])->group(function () {
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/unauthorized', 'unauthorized')->name('unauthorized');

Route::middleware(['auth'])->group(function () {

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/allusers', [UserController::class, 'allusers'])->name('allusers');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
        Route::get('/lock/{id}', [UserController::class, 'lock'])->name('lock');
        Route::get('/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::get('/myprofile', [UserController::class, 'myprofile'])->name('myprofile');
    });


});

// this for islocked
});

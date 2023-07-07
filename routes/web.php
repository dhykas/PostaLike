<?php

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::get('/', [Controller::class, 'index'])->name('index');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::get('/register', 'register')->name('register');
    Route::post('/logins', 'logins')->name('logins');
    Route::post('/registers', 'registers')->name('registers');

    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(UserController::class)->group(function () {
    Route::get('user/{name}', 'show');
    Route::get('/acc/edit', 'edit')->middleware(Authenticate::class);
    Route::get('/create', 'create')->middleware(Authenticate::class);
    Route::post('/post', 'post')->middleware(Authenticate::class);
    Route::post('/like/{id}', 'like')->middleware(Authenticate::class);
    Route::post('/edits', 'edits')->name('edits');
});


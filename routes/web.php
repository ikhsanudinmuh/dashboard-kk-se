<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleProviderController;
use App\Http\Controllers\PublicationController;
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
    return view('index');
});

//google auth routes
Route::get('/redirect', [GoogleProviderController::class, 'redirect'])->name('redirect');
Route::get('/callback', [GoogleProviderController::class, 'callback'])->name('callback');

//auth routes
Route::get('/login', [AuthController::class, 'loginPage']);
// Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
// Route::get('/register', [AuthController::class, 'registerPage']);
// Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

//publication routes
Route::get('/publication', [PublicationController::class, 'index']);
Route::post('/publication', [PublicationController::class, 'store'])->name('publication.store');


<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleProviderController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ResearchTypeController;
use App\Http\Controllers\UserController;
use App\Models\Publication;
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
Route::get('/publication/stats/{view}', [PublicationController::class, 'stats'])->name('publication.stats');

//publication stats routes
Route::get('/publication/get_stats/per_year', [PublicationController::class, 'publicationPerYear']);
Route::get('/publication/get_stats/per_author', [PublicationController::class, 'publicationPerAuthor']);
Route::get('/publication/get_stats/per_author_per_year/{id}', [PublicationController::class, 'publicationPerAuthorPerYear']);
Route::get('/publication/get_stats/per_publication_type', [PublicationController::class, 'publicationType']);
Route::get('/publication/get_stats/per_journal_accreditation', [PublicationController::class, 'journalAccreditation']);

//admin routes
    //manage user routes
    Route::get('/user/manage', [UserController::class, 'index']);
    Route::put('/user/manage/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/manage/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    //manage publication routes
    Route::get('/publication/manage', [PublicationController::class, 'manage']);
    Route::put('/publication/manage/{id}', [PublicationController::class, 'update'])->name('publication.update');
    Route::delete('/publication/manage/delete/{id}', [PublicationController::class, 'destroy'])->name('publication.destroy');
    
    //manage research type routes
    Route::get('/research_type/manage', [ResearchTypeController::class, 'index']);
    Route::post('/research_type/manage', [ResearchTypeController::class, 'store'])->name('research_type.store');
    Route::put('/research_type/manage/{id}', [ResearchTypeController::class, 'update'])->name('research_type.update');
    Route::delete('/research_type/manage/delete/{id}', [ResearchTypeController::class, 'destroy'])->name('research_type.destroy');

    


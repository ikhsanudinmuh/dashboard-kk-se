<?php

use App\Http\Controllers\AbdimasController;
use App\Http\Controllers\AbdimasTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleProviderController;
use App\Http\Controllers\HkiController;
use App\Http\Controllers\JournalAccreditationController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\PatentTypeController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\PublicationTypeController;
use App\Http\Controllers\ResearchController;
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
    //manage publication routes
    Route::get('/publication/manage', [PublicationController::class, 'manage']);
    Route::put('/publication/manage/{id}', [PublicationController::class, 'update'])->name('publication.update');
    Route::delete('/publication/manage/delete/{id}', [PublicationController::class, 'destroy'])->name('publication.destroy');
    //get publication stats routes
    Route::get('/publication/get_stats/per_year', [PublicationController::class, 'publicationPerYear']);
    Route::get('/publication/get_stats/per_author', [PublicationController::class, 'publicationPerAuthor']);
    Route::get('/publication/get_stats/per_author_per_year/{id}', [PublicationController::class, 'publicationPerAuthorPerYear']);
    Route::get('/publication/get_stats/per_publication_type', [PublicationController::class, 'publicationType']);
    Route::get('/publication/get_stats/per_journal_accreditation', [PublicationController::class, 'journalAccreditation']);
    
//research routes
    Route::get('/research', [ResearchController::class, 'index']);
    Route::post('/research', [ResearchController::class, 'store'])->name('research.store');
    Route::get('/research/stats/{view}', [ResearchController::class, 'stats'])->name('research.stats');
    //manage research routes
    Route::get('/research/manage', [ResearchController::class, 'manage']);
    Route::put('/research/manage/{id}', [ResearchController::class, 'update'])->name('research.update');
    Route::delete('/research/manage/delete/{id}', [ResearchController::class, 'destroy'])->name('research.destroy');
    //get research stats routes
    Route::get('/research/get_stats/per_year', [ResearchController::class, 'researchPerYear']);
    Route::get('/research/get_stats/per_member', [ResearchController::class, 'researchPerMember']);
    Route::get('/research/get_stats/per_member_per_year/{id}', [ResearchController::class, 'researchPerMemberPerYear']);
    Route::get('/research/get_stats/per_research_type', [ResearchController::class, 'researchType']);

//hki routes
    Route::get('/hki', [HkiController::class, 'index']);
    Route::post('/hki', [HkiController::class, 'store'])->name('hki.store');
    Route::get('/hki/stats/{view}', [HkiController::class, 'stats'])->name('hki.stats');
    //manage hki routes
    Route::get('/hki/manage', [HkiController::class, 'manage']);
    Route::put('/hki/manage/{id}', [HkiController::class, 'update'])->name('hki.update');
    Route::delete('/hki/manage/delete/{id}', [HkiController::class, 'destroy'])->name('hki.destroy');
    //get hki stats routes
    Route::get('/hki/get_stats/per_year', [HkiController::class, 'hkiPerYear']);
    Route::get('/hki/get_stats/per_member', [HkiController::class, 'hkiPerMember']);
    Route::get('/hki/get_stats/per_member_per_year/{id}', [HkiController::class, 'hkiPerMemberPerYear']);
    Route::get('/hki/get_stats/per_patent_type', [HkiController::class, 'patentType']);
    
//abdimas routes
    Route::get('/abdimas', [AbdimasController::class, 'index']);
    Route::post('/abdimas', [AbdimasController::class, 'store'])->name('abdimas.store');
    Route::get('/abdimas/stats/{view}', [AbdimasController::class, 'stats'])->name('abdimas.stats');
    //manage abdimas routes
    Route::get('/abdimas/manage', [AbdimasController::class, 'manage']);
    Route::put('/abdimas/manage/{id}', [AbdimasController::class, 'update'])->name('abdimas.update');
    Route::delete('/abdimas/manage/delete/{id}', [AbdimasController::class, 'destroy'])->name('abdimas.destroy');
    //get abdimas stats routes
    Route::get('/abdimas/get_stats/per_year', [AbdimasController::class, 'abdimasPerYear']);
    Route::get('/abdimas/get_stats/per_member', [AbdimasController::class, 'abdimasPerMember']);
    Route::get('/abdimas/get_stats/per_member_per_year/{id}', [AbdimasController::class, 'abdimasPerMemberPerYear']);
    Route::get('/abdimas/get_stats/per_abdimas_type', [AbdimasController::class, 'abdimasType']);

//admin routes
    //manage user data routes
    Route::get('/user/manage', [UserController::class, 'index']);
    Route::put('/user/manage/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/manage/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    
    //manage publication type data routes
    Route::get('/publication_type/manage', [PublicationTypeController::class, 'index']);
    Route::post('/publication_type/manage', [PublicationTypeController::class, 'store'])->name('publication_type.store');
    Route::put('/publication_type/manage/{id}', [PublicationTypeController::class, 'update'])->name('publication_type.update');
    Route::delete('/publication_type/manage/delete/{id}', [PublicationTypeController::class, 'destroy'])->name('publication_type.destroy');

    //manage journal accreditation data routes
    Route::get('/journal_accreditation/manage', [JournalAccreditationController::class, 'index']);
    Route::post('/journal_accreditation/manage', [JournalAccreditationController::class, 'store'])->name('journal_accreditation.store');
    Route::put('/journal_accreditation/manage/{id}', [JournalAccreditationController::class, 'update'])->name('journal_accreditation.update');
    Route::delete('/journal_accreditation/manage/delete/{id}', [JournalAccreditationController::class, 'destroy'])->name('journal_accreditation.destroy');

    //manage lab data routes
    Route::get('/lab/manage', [LabController::class, 'index']);
    Route::post('/lab/manage', [LabController::class, 'store'])->name('lab.store');
    Route::put('/lab/manage/{id}', [LabController::class, 'update'])->name('lab.update');
    Route::delete('/lab/manage/delete/{id}', [LabController::class, 'destroy'])->name('lab.destroy');

    //manage research type data routes
    Route::get('/research_type/manage', [ResearchTypeController::class, 'index']);
    Route::post('/research_type/manage', [ResearchTypeController::class, 'store'])->name('research_type.store');
    Route::put('/research_type/manage/{id}', [ResearchTypeController::class, 'update'])->name('research_type.update');
    Route::delete('/research_type/manage/delete/{id}', [ResearchTypeController::class, 'destroy'])->name('research_type.destroy');
    
    //manage patent type data routes
    Route::get('/patent_type/manage', [PatentTypeController::class, 'index']);
    Route::post('/patent_type/manage', [PatentTypeController::class, 'store'])->name('patent_type.store');
    Route::put('/patent_type/manage/{id}', [PatentTypeController::class, 'update'])->name('patent_type.update');
    Route::delete('/patent_type/manage/delete/{id}', [PatentTypeController::class, 'destroy'])->name('patent_type.destroy');
    
    //manage abdimas type data routes
    Route::get('/abdimas_type/manage', [AbdimasTypeController::class, 'index']);
    Route::post('/abdimas_type/manage', [AbdimasTypeController::class, 'store'])->name('abdimas_type.store');
    Route::put('/abdimas_type/manage/{id}', [AbdimasTypeController::class, 'update'])->name('abdimas_type.update');
    Route::delete('/abdimas_type/manage/delete/{id}', [AbdimasTypeController::class, 'destroy'])->name('abdimas_type.destroy');


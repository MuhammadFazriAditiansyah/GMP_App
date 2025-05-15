<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FindingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;
use App\Models\Finding;

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
    $findings = Finding::with('closing')->latest()->get(); // Ambil semua data finding + relasi closing
    return view('landingpage', compact('findings'));
});

Route::get('/landingpage', [FindingController::class, 'landing'])->name('landing');
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/loginAuth', [UserController::class, 'loginAuth'])->name('login.auth');
Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.store');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/error-permission', function () {
    return view('errors.permission');
})->name('error.permission');

Route::middleware('IsLogin')->group(function () {

    Route::get('/home', [FindingController::class, 'home'])->name('home');
    Route::get('/finding-closing', [FindingController::class, 'index'])->name('findings.index');
    Route::get('/export-findings', [ExportController::class, 'exportFindings'])->name('findings.export');
    Route::get('/findings/export-pdf', [ExportController::class, 'exportPDF'])->name('findings.exportPDF');
    Route::get('/profile', [UserController::class, 'index'])->name('user.index');
    Route::get('/profile/tambah', [UserController::class, 'create'])->name('user.create');
    Route::post('/profile/submit', [UserController::class, 'submit'])->name('user.submit');
    Route::get('/profile/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/profile/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/profile/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');

Route::middleware('IsAdmin')->group(function () {

    Route::get('/finding/create', [FindingController::class, 'create'])->name('findings.create');
    Route::post('/finding/submit', [FindingController::class, 'submit'])->name('findings.submit');
    Route::get('/finding/edit/{id}', [FindingController::class, 'edit'])->name('findings.edit');
    Route::post('/finding/update/{id}', [FindingController::class, 'update'])->name('findings.update');
    Route::delete('/finding/delete/{id}', [FindingController::class, 'destroy'])->name('findings.delete');
    Route::patch('/findings/{id}/toggle-status', [FindingController::class, 'toggleStatus'])->name('findings.toggleStatus');

});

Route::middleware('IsUser')->group(function () {

    Route::get('/findings/upload-photo/{id}', [FindingController::class, 'uploadPhotoForm'])->name('findings.uploadPhotoForm');
    Route::post('/findings/upload-photo/{id}', [FindingController::class, 'uploadPhotoSubmit'])->name('findings.uploadPhotoSubmit');
    Route::get('/findings/{id}/edit-photo', [FindingController::class, 'editPhotoForm'])->name('findings.editPhotoForm');
    Route::get('/findings/{id}/edit-photo', [FindingController::class, 'editPhotoForm'])->name('findings.editPhotoForm');
    Route::post('/findings/{id}/edit-photo', [FindingController::class, 'updatePhoto'])->name('findings.updatePhoto');

});


});

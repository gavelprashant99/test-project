<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;

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
    return view('welcome');
});

Route::middleware(['web'])->group(function () {
    Route::get('/index', function () {
        return view('index');
    });
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [CustomAuthController::class, 'logout']);
    Route::get('dashboard', [CustomAuthController::class, 'dashboard']);

    //For ULB Registration
    Route::get('dashboard/ulbregistration', [CustomAuthController::class, 'ulbRegistration'])->name('dashboard.ulbregistration');
    Route::post('dashboard/register-ulb', [CustomAuthController::class, 'registerUlb'])->name('register-ulb');

    //Upload documents
    Route::get('dashboard/uploaddocument', [CustomAuthController::class, 'doocUploadForm']);
    Route::post('dashboard/uploaddocument', [CustomAuthController::class, 'docUpload'])->name('upload-doc');

    //View Documents
    // Route::get('/dashboard/documents', [CustomAuthController::class, 'getDoc']);
    Route::get('/dashboard/documents/modal/{id}',[CustomAuthController::class, 'showDocumentModal'])->name('documents.modal');
    Route::post('/dashboard/documents/verify/{id}',[CustomAuthController::class, 'getDocuments']);
    // routes/web.php
Route::get('dashboard/user-document/{id}',[CustomAuthController::class, 'show'])->name('documents.show');


    //For ULB list
    Route::get('dashboard/ulblist', [CustomAuthController::class, 'ulbList']);

    //For Password reset
    Route::get('dashboard/passwordreset', [CustomAuthController::class, 'showPasswordResetForm'])->name('dashboard.passwordreset');
    Route::post('dashboard/passwordreset', [CustomAuthController::class, 'resetPassword']);

    //for file verification
        Route::get('dashboard/verify/{id}', [CustomAuthController::class, 'showVerificationForm']);
        Route::post('dashboard/verify/{id}', [CustomAuthController::class, 'verifyDocument']);
});


Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [CustomAuthController::class, 'index'])->name('login');
    Route::post('login', [CustomAuthController::class, 'login'])->name('login');
    Route::get('registration', [CustomAuthController::class, 'registration']);
    Route::post('register-user', [CustomAuthController::class, 'registerUser'])->name('register-user');
});

// Route::get('/ulblist', [CustomAuthController::class, 'ulbList']);
Route::get('/ulblogin', [CustomAuthController::class, 'ulbLogin']);
Route::get('/login-ulb', [CustomAuthController::class, 'loginUlb'])->name('login-ulb');
Route::get('/stateportalreg', [CustomAuthController::class, 'stateportalreg']);
Route::post('/register-stateportal', [CustomAuthController::class, 'registerStatePortal'])->name('register-stateportal');
Route::get('/stateportallogin', [CustomAuthController::class, 'stateportallogin']);
Route::get('/login-stateportal', [CustomAuthController::class, 'loginStatePortal'])->name('login-stateportal');
Route::get('/captcha', [CustomAuthController::class, 'generateRandomCaptcha']);
Route::get('/chart', [CustomAuthController::class, 'showChart']);
Route::get('/distportalreg', [CustomAuthController::class, 'distportalreg']);
Route::post('/register-distportal', [CustomAuthController::class, 'registerDistPortal'])->name('register-distportal');
Route::get('/distportallogin', [CustomAuthController::class, 'distportallogin']);
Route::get('/login-distportal', [CustomAuthController::class, 'loginDistPortal'])->name('login-distportal');
Route::get('/get-districts/{sambhagId}', [CustomAuthController::class, 'getDistricts']);
Route::get('/get-nagarnigam/{districtId}', [CustomAuthController::class, 'getNagarNigam']);
Route::get('/get-nagarpalika/{districtId}', [CustomAuthController::class, 'getNagarPalika']);
Route::get('/get-nagarpanchayat/{districtId}', [CustomAuthController::class, 'getNagarPanchayat']);

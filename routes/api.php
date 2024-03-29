<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LgaController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\User\PasswordController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Frontend\UserAddressController;
use App\Http\Controllers\Frontend\VendorAddressController;
use App\Http\Controllers\Frontend\VendorRequestController;
use App\Http\Controllers\Frontend\VendorServicesController;
use App\Http\Controllers\LicenseIssuingBodyController;
use App\Http\Controllers\ServicesController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('forgot-password', [PasswordController::class, 'forgotPassword'])->name('forgot-password');
Route::post('reset-password', [PasswordController::class, 'resetPassword'])->name('reset-password');
Route::get('/services', [ServicesController::class, 'fetchAllServices'])->name('fetch-services');
Route::get('/license-issuing-bodies', [LicenseIssuingBodyController::class, 'fetchAllLicenseIssuingBodies'])->name('fetch-license-bodies');
Route::get('countries/{country_id}/states', [StateController::class, 'fetchCountryStates'])->name('fetch-country-states');
Route::get('states/{state_id}/lgas', [LgaController::class, 'fetchStateLgas'])->name('fetch-state-lgas');
Route::get('countries', [CountryController::class, 'fetchAllCountries'])->name('fetch-countries');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return response()->json(['message' => 'Email verified successfully!'], 200);
})->middleware(['auth:api', 'signed'])->name('verification.verify');
// Route::post('email/verify', [AuthController::class, 'verifyEmailToken'])->name('verify.email');
// Route::post('email/request-token', [AuthController::class, 'requestEmailVerificationToken'])->name('email.request-token');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/vendor-service', VendorServicesController::class);
    Route::apiResource('/vendor-address', VendorAddressController::class);
    Route::post('/vendor-request', [VendorRequestController::class, 'store'])->name('vendor-request');
    Route::apiResource('address', UserAddressController::class);
    Route::get('dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::put('/profile/update', [ProfileController::class, 'updateUserProfile'])->name('profile.update');
    Route::post('/profile/upload-image', [ProfileController::class, 'updateUserImage'])->name('profile.upload-image');
    Route::patch('/update-password', [PasswordController::class, 'updateUserPassword']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
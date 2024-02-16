<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
Route::get('countries/{country_id}/states', [StateController::class, 'fetchCountryStates'])->name('fetch-country-states');
Route::get('countries', [CountryController::class, 'fetchAllCountries'])->name('fetch-countries');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('email/verify', [AuthController::class, 'verifyEmailToken'])->name('verify.email');
Route::post('email/request-token', [AuthController::class, 'requestEmailVerificationToken'])->name('email.request-token');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('address', UserAddressController::class);
    Route::get('dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::put('/profile/update', [ProfileController::class, 'updateUserProfile'])->name('profile.update');
    Route::post('/profile/upload-image', [ProfileController::class, 'updateUserImage'])->name('profile.upload-image');
    Route::patch('/update-password', [PasswordController::class, 'updateUserPassword']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

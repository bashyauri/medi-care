<?php

use App\Http\Controllers\Backend\AdminController;
use Illuminate\Support\Facades\Route;


/** Vendor Routes */
Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');

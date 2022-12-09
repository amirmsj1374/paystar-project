<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::controller(PaymentController::class)->name('payment.')->group(function () {
    Route::get('/', 'checkout')->name('checkout');
    Route::post('/payment', 'create')->name('create');
    Route::get('/invoice', 'invoice')->middleware('check.refnum')->name('invoice');
});


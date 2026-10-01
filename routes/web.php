<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\MaskapaiController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PenerbanganController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/bookings');



Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::name('travel.')->group(function () {
    Route::resource('bookings', BookingController::class)->except(['show']);
    Route::get('bookings/{booking}/pdf', [BookingController::class, 'pdf'])->name('bookings.pdf');
    Route::post('bookings/{booking}/duplicate', [BookingController::class, 'duplicate'])->name('bookings.duplicate');

    Route::resource('maskapai', MaskapaiController::class)->except(['show']);
    Route::resource('wilayah', WilayahController::class)->except(['show']);
    Route::resource('penerbangan', PenerbanganController::class)->except(['show']);
    Route::resource('invoices', InvoiceController::class)->except(['create']);
    Route::post('invoices/create-hotel', [InvoiceController::class, 'createHotel'])->name('invoices.create-hotel');

    // kalender 
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('calendar/events', [CalendarController::class, 'events'])->name('calendar.events');
});

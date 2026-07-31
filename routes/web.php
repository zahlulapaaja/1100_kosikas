<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\MaskapaiController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/bookings');

Route::resource('bookings', BookingController::class)->except(['show']);
Route::get('bookings/{booking}/pdf', [BookingController::class, 'pdf'])->name('bookings.pdf');

Route::resource('maskapai', MaskapaiController::class)->except(['show']);
Route::resource('wilayah', WilayahController::class)->except(['show']);

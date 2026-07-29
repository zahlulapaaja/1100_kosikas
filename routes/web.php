<?php

use App\Http\Controllers\ETicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ETicketController::class, 'index'])->name('eticket.index');
Route::post('/eticket/generate', [ETicketController::class, 'generate'])->name('eticket.generate');

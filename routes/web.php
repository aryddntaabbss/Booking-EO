<?php

use App\Http\Controllers\PublicBookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicBookingController::class, 'index'])->name('home');
Route::get('/kategori/{category:slug}', [PublicBookingController::class, 'category'])->name('categories.show');
Route::get('/paket/{package}', [PublicBookingController::class, 'package'])->name('packages.show');

Route::get('/booking/create/{package}', [PublicBookingController::class, 'create'])->name('bookings.create');
Route::post('/booking', [PublicBookingController::class, 'store'])->name('bookings.store');

Route::get('/booking/status', [PublicBookingController::class, 'statusForm'])->name('bookings.status.form');
Route::post('/booking/status', [PublicBookingController::class, 'statusSearch'])->name('bookings.status.search');
Route::post('/booking/{booking}/payment-proof', [PublicBookingController::class, 'uploadPaymentProof'])->name('bookings.payment-proof');

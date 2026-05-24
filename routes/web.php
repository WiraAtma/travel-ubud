<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('home');

Route::get('/destinasi', function () {
    return '<h1>Halaman Destinasi</h1><a href="/">Kembali</a>';
})->name('destinasi');

Route::get('/galeri', function () {
    return '<h1>Halaman Galeri</h1><a href="/">Kembali</a>';
})->name('galeri');

Route::get('/restoran', function () {
    return '<h1>Halaman Restoran</h1><a href="/">Kembali</a>';
})->name('restoran');

Route::get('/hotel', function () {
    return '<h1>Halaman Hotel</h1><a href="/">Kembali</a>';
})->name('hotel');

Route::get('/about-us', function () {
    return '<h1>Halaman Tentang Kami</h1><a href="/">Kembali</a>';
})->name('about-us');

Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', 'verified'])->name('admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
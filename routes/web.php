<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', function () {
    return view('dashboard');
})->name('home');

Route::get('/destinasi', function () {
    return view('features.dashboard.destinasi-dashboard');
})->name('destinasi');

Route::get('/article', function () {
    return view('features.dashboard.article-dashboard');
})->name('article');

Route::get('/galeri', function () {
    return view('features.dashboard.galeri-dashboard');
})->name('galeri');

Route::get('/restoran', function () {
    return view('features.dashboard.restoran-dashboard');
})->name('restoran');

Route::get('/hotel', function () {
    return view('features.dashboard.hotel-dashboard');
})->name('hotel');

Route::get('/about-us', function () {
    return view('features.dashboard.about-us-dashboard');
})->name('about-us');

// Admin
Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', 'verified'])->name('admin');

Route::get('/admin/list-user', [UserController::class, 'page'])->middleware(['auth', 'verified'])->name('users.page');

Route::get('/admin/request-company', function () {
    return view('features.admin.request-company-admin');
})->middleware(['auth', 'verified'])->name('admin.request-company');

Route::get('/manage-post', function () {
    return view('features.admin.list-post-destinasi-dashboard');
})->middleware(['auth', 'verified'])->name('manage-post');

Route::get('/form-post', function () {
    return view('features.dashboard.form-post-dashboard');
})->middleware(['auth', 'verified'])->name('form-post');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
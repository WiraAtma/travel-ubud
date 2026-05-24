<?php

use App\Http\Controllers\Article\ArticleController;
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

Route::get('/admin/manage-post', function () {
    return view('features.admin.list-post-destinasi-dashboard');
})->middleware(['auth', 'verified'])->name('manage-post');

Route::get('/admin/form-post', function () {
    return view('features.dashboard.form-post-dashboard');
})->middleware(['auth', 'verified'])->name('form-post');

Route::get('/admin/article', [ArticleController::class, 'index'])
->middleware(['auth', 'verified'])->name('articles.index');

Route::get('/admin/article/all', [ArticleController::class, 'getAll'])
->middleware(['auth', 'verified'])->name('articles.all');


// Add the missing routes for article management
Route::get('/admin/article/create', [ArticleController::class, 'create'])
->middleware(['auth', 'verified'])->name('articles.create');

Route::post('/admin/article', [ArticleController::class, 'store'])
->middleware(['auth', 'verified'])->name('articles.store');

Route::get('/admin/article/{article}/edit', [ArticleController::class, 'edit'])
->middleware(['auth', 'verified'])->name('articles.edit');

Route::put('/admin/article/{article}', [ArticleController::class, 'update'])
->middleware(['auth', 'verified'])->name('articles.update');

Route::delete('/admin/article/{article}', [ArticleController::class, 'destroy'])
->middleware(['auth', 'verified'])->name('articles.destroy');

Route::post('/admin/article/{article}/ban', [ArticleController::class, 'ban'])
->middleware(['auth', 'verified'])->name('articles.ban');

Route::post('/admin/article/{article}/unban', [ArticleController::class, 'unban'])
->middleware(['auth', 'verified'])->name('articles.unban');

Route::post('/admin/article/upload-image', [ArticleController::class, 'uploadImage'])
    ->middleware(['auth', 'verified'])
    ->name('articles.upload-image');

Route::get('/admin/form-article', function () {
    return view('features.form.article.create-article');
})->middleware(['auth', 'verified'])->name('form-article');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
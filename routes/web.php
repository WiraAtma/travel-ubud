<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Destination\DestinationController;

Route::view('/', 'dashboard')->name('home');

Route::prefix('/')->group(function () {
    Route::view('destinasi', 'features.dashboard.destinasi-dashboard')
        ->name('destinasi');

    Route::view('article', 'features.dashboard.article-dashboard')
        ->name('article');

    Route::view('galeri', 'features.dashboard.galeri-dashboard')
        ->name('galeri');

    Route::view('restoran', 'features.dashboard.restoran-dashboard')
        ->name('restoran');

    Route::view('hotel', 'features.dashboard.hotel-dashboard')
        ->name('hotel');

    Route::view('about-us', 'features.dashboard.about-us-dashboard')
        ->name('about-us');
});

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->group(function () {

        Route::view('/', 'admin')->name('admin');

        Route::get('/list-user', [UserController::class, 'page'])
            ->name('users.page');

        Route::view('/request-company', 'features.admin.request-company-admin')
            ->name('admin.request-company');

        Route::view('/manage-post', 'features.admin.list-post-destinasi-dashboard')
            ->name('manage-post');

        Route::view('/form-post', 'features.dashboard.form-post-dashboard')
            ->name('form-post');

        Route::view('/form-article', 'features.form.article.create-article')
            ->name('form-article');

        Route::prefix('article')
            ->name('articles.')
            ->group(function () {

                Route::get('/', [ArticleController::class, 'index'])
                    ->name('index');

                Route::get('/all', [ArticleController::class, 'getAll'])
                    ->name('all');

                Route::get('/create', [ArticleController::class, 'create'])
                    ->name('create');

                Route::post('/', [ArticleController::class, 'store'])
                    ->name('store');

                Route::post('/upload-image', [ArticleController::class, 'uploadImage'])
                    ->name('upload-image');

                Route::get('/{article}/edit', [ArticleController::class, 'edit'])
                    ->name('edit');

                Route::put('/{article}', [ArticleController::class, 'update'])
                    ->name('update');

                Route::delete('/{article}', [ArticleController::class, 'destroy'])
                    ->name('destroy');

                Route::post('/{article}/ban', [ArticleController::class, 'ban'])
                    ->name('ban');

                Route::post('/{article}/unban', [ArticleController::class, 'unban'])
                    ->name('unban');
            });

        Route::prefix('destination')
            ->name('destinations.')
            ->group(function () {

                Route::get('/', [DestinationController::class, 'index'])
                    ->name('index');

                Route::get('/all', [DestinationController::class, 'getAll'])
                    ->name('all');

                Route::get('/create', [DestinationController::class, 'create'])
                    ->name('create');

                Route::post('/', [DestinationController::class, 'store'])
                    ->name('store');

                Route::post('/upload-image', [DestinationController::class, 'uploadImage'])
                    ->name('upload-image');

                Route::get('/{destination}/edit', [DestinationController::class, 'edit'])
                    ->name('edit');

                Route::put('/{destination}', [DestinationController::class, 'update'])
                    ->name('update');

                Route::delete('/{destination}', [DestinationController::class, 'destroy'])
                    ->name('destroy');

                Route::post('/{destination}/ban', [DestinationController::class, 'ban'])
                    ->name('ban');

                Route::post('/{destination}/unban', [DestinationController::class, 'unban'])
                    ->name('unban');
            });
    });

Route::middleware('auth')
    ->prefix('profile')
    ->name('profile.')
    ->group(function () {

        Route::get('/', [ProfileController::class, 'edit'])
            ->name('edit');

        Route::patch('/', [ProfileController::class, 'update'])
            ->name('update');

        Route::delete('/', [ProfileController::class, 'destroy'])
            ->name('destroy');
    });

require __DIR__ . '/auth.php';
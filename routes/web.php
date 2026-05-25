<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Company\CompanyRequestController;
use App\Http\Controllers\Destination\DestinationController;
use App\Http\Controllers\Hotel\HotelController;
use App\Http\Controllers\Restaurant\RestaurantController;

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/company-request', [CompanyRequestController::class, 'store'])
        ->name('company-request.store');
    Route::delete('/company-request/cancel', [CompanyRequestController::class, 'cancel'])
        ->name('company-request.cancel');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/request-company', [CompanyRequestController::class, 'index'])
        ->name('admin.request-company');
    Route::post('/request-company/{companyRequest}/approve', [CompanyRequestController::class, 'approve'])
        ->name('admin.request-company.approve');
    Route::post('/request-company/{companyRequest}/reject', [CompanyRequestController::class, 'reject'])
        ->name('admin.request-company.reject');
    Route::get('/request-company/{companyRequest}/proof', [CompanyRequestController::class, 'viewProof'])
        ->name('admin.request-company.proof');
});

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->group(function () {

        Route::view('/', 'admin')->name('admin');

        Route::get('/list-user', [UserController::class, 'page'])
            ->name('users.page');

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

Route::middleware(['auth', 'verified'])->group(function () {
 
    Route::get('/admin/hotel', [HotelController::class, 'index'])
        ->name('hotels.index');
 
    Route::get('/admin/hotel/all', [HotelController::class, 'getAll'])
        ->name('hotels.all');
 
    Route::get('/admin/hotel/create', [HotelController::class, 'create'])
        ->name('hotels.create');
 
    Route::post('/admin/hotel', [HotelController::class, 'store'])
        ->name('hotels.store');

    Route::post('/admin/hotel/upload-image', [HotelController::class, 'uploadImage'])
        ->name('hotels.upload-image');
 
    Route::get('/admin/hotel/{hotel}/edit', [HotelController::class, 'edit'])
        ->name('hotels.edit');
 
    Route::put('/admin/hotel/{hotel}', [HotelController::class, 'update'])
        ->name('hotels.update');
 
    Route::delete('/admin/hotel/{hotel}', [HotelController::class, 'destroy'])
        ->name('hotels.destroy');
 
    Route::post('/admin/hotel/{hotel}/ban', [HotelController::class, 'ban'])
        ->name('hotels.ban');
 
    Route::post('/admin/hotel/{hotel}/unban', [HotelController::class, 'unban'])
        ->name('hotels.unban');
 
});

Route::middleware(['auth', 'verified'])->group(function () {
 
    Route::get('/admin/restaurant', [RestaurantController::class, 'index'])
        ->name('restaurants.index');
 
    Route::get('/admin/restaurant/all', [RestaurantController::class, 'getAll'])
        ->name('restaurants.all');
 
    Route::get('/admin/restaurant/create', [RestaurantController::class, 'create'])
        ->name('restaurants.create');
 
    Route::post('/admin/restaurant', [RestaurantController::class, 'store'])
        ->name('restaurants.store');
 
    Route::post('/admin/restaurant/upload-image', [RestaurantController::class, 'uploadImage'])
        ->name('restaurants.upload-image');
 
    Route::get('/admin/restaurant/{restaurant}/edit', [RestaurantController::class, 'edit'])
        ->name('restaurants.edit');
 
    Route::put('/admin/restaurant/{restaurant}', [RestaurantController::class, 'update'])
        ->name('restaurants.update');
 
    Route::delete('/admin/restaurant/{restaurant}', [RestaurantController::class, 'destroy'])
        ->name('restaurants.destroy');
 
    Route::post('/admin/restaurant/{restaurant}/ban', [RestaurantController::class, 'ban'])
        ->name('restaurants.ban');
 
    Route::post('/admin/restaurant/{restaurant}/unban', [RestaurantController::class, 'unban'])
        ->name('restaurants.unban');
 
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
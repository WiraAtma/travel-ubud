<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Company\CompanyRequestController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Destination\DestinationController;
use App\Http\Controllers\Destination\DestinationCommentController;
use App\Http\Controllers\Destination\DestinationRatingController;
use App\Http\Controllers\Hotel\HotelCommentController;
use App\Http\Controllers\Hotel\HotelController;
use App\Http\Controllers\Hotel\HotelRatingController;
use App\Http\Controllers\Restaurant\RestaurantCommentController;
use App\Http\Controllers\Restaurant\RestaurantController;
use App\Http\Controllers\Restaurant\RestaurantRatingController;
use App\Http\Controllers\Article\ArticleCommentController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::get('destinasi', [DestinationController::class, 'page'])->name('destinasi');
Route::get('destinasi/{destination}', [DestinationController::class, 'detail'])->name('destinations.detail');

Route::get('article', [ArticleController::class, 'page'])->name('article');
Route::get('article/{article}', [ArticleController::class, 'detail'])->name('articles.detail');

Route::view('galeri', 'features.dashboard.galeri-dashboard')->name('galeri');

Route::get('restoran', [RestaurantController::class, 'page'])->name('restoran');
Route::get('restoran/{restaurant}', [RestaurantController::class, 'detail'])->name('restaurants.detail');

Route::get('hotel', [HotelController::class, 'page'])->name('hotel');
Route::get('hotel/{hotel}', [HotelController::class, 'detail'])->name('hotels.detail');

Route::view('about-us', 'features.dashboard.about-us-dashboard')->name('about-us');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Company Request
    Route::post('/company-request', [CompanyRequestController::class, 'store'])
        ->name('company-request.store');
    Route::delete('/company-request/cancel', [CompanyRequestController::class, 'cancel'])
        ->name('company-request.cancel');

    // Destination Comments & Rating
    Route::post('/destinasi/{destination}/comments', [DestinationCommentController::class, 'store'])
        ->name('destination.comments.store');
    Route::put('/destinasi/comments/{comment}', [DestinationCommentController::class, 'update'])
        ->name('destination.comments.update');
    Route::delete('/destinasi/comments/{comment}', [DestinationCommentController::class, 'destroy'])
        ->name('destination.comments.destroy');
    Route::post('/destinasi/{destination}/rating', [DestinationRatingController::class, 'store'])
        ->name('destination.rating.store');
    
    // Hotel Comment and Rating
    Route::post('/hotel/{hotel}/comments', [HotelCommentController::class, 'store'])
        ->name('hotel.comments.store');
    Route::put('/hotel/comments/{comment}', [HotelCommentController::class, 'update'])
        ->name('hotel.comments.update');
    Route::delete('/hotel/comments/{comment}', [HotelCommentController::class, 'destroy'])
        ->name('hotel.comments.destroy');
    Route::post('/hotel/{hotel}/rating', [HotelRatingController::class, 'store'])
        ->name('hotel.rating.store');

    // Restaurant Comment and Rating
    Route::post('/restoran/{restaurant}/comments', [RestaurantCommentController::class, 'store'])
        ->name('restaurant.comments.store');
    Route::put('/restoran/comments/{comment}', [RestaurantCommentController::class, 'update'])
        ->name('restaurant.comments.update');
    Route::delete('/restoran/comments/{comment}', [RestaurantCommentController::class, 'destroy'])
        ->name('restaurant.comments.destroy');
    Route::post('/restoran/{restaurant}/rating', [RestaurantRatingController::class, 'store'])
        ->name('restaurant.rating.store');

    // Article Comment (no rating)
    Route::post('/article/{article}/comments', [ArticleCommentController::class, 'store'])
        ->name('article.comments.store');
    Route::put('/article/comments/{comment}', [ArticleCommentController::class, 'update'])
        ->name('article.comments.update');
    Route::delete('/article/comments/{comment}', [ArticleCommentController::class, 'destroy'])
        ->name('article.comments.destroy');
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('profile')
    ->name('profile.')
    ->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->group(function () {

        Route::view('/', 'admin')->name('admin');

        // Company Request Management
        Route::prefix('request-company')
            ->name('admin.request-company.')
            ->group(function () {
                Route::get('/', [CompanyRequestController::class, 'index'])->name('index');
                Route::post('/{companyRequest}/approve', [CompanyRequestController::class, 'approve'])->name('approve');
                Route::post('/{companyRequest}/reject', [CompanyRequestController::class, 'reject'])->name('reject');
                Route::get('/{companyRequest}/proof', [CompanyRequestController::class, 'viewProof'])->name('proof');
            });

        // User Management
        Route::get('/list-user', [UserController::class, 'page'])->name('users.page');

        // Post Management (views)
        Route::view('/manage-post', 'features.admin.list-post-destinasi-dashboard')->name('manage-post');
        Route::view('/form-post', 'features.dashboard.form-post-dashboard')->name('form-post');
        Route::view('/form-article', 'features.form.article.create-article')->name('form-article');

        // Article Management
        Route::prefix('article')
            ->name('articles.')
            ->group(function () {
                Route::get('/', [ArticleController::class, 'index'])->name('index');
                Route::get('/all', [ArticleController::class, 'getAll'])->name('all');
                Route::get('/create', [ArticleController::class, 'create'])->name('create');
                Route::post('/', [ArticleController::class, 'store'])->name('store');
                Route::post('/upload-image', [ArticleController::class, 'uploadImage'])->name('upload-image');
                Route::get('/{article}/edit', [ArticleController::class, 'edit'])->name('edit');
                Route::put('/{article}', [ArticleController::class, 'update'])->name('update');
                Route::delete('/{article}', [ArticleController::class, 'destroy'])->name('destroy');
                Route::post('/{article}/ban', [ArticleController::class, 'ban'])->name('ban');
                Route::post('/{article}/unban', [ArticleController::class, 'unban'])->name('unban');
            });

        // Destination Management
        Route::prefix('destination')
            ->name('destinations.')
            ->group(function () {
                Route::get('/', [DestinationController::class, 'index'])->name('index');
                Route::get('/all', [DestinationController::class, 'getAll'])->name('all');
                Route::get('/create', [DestinationController::class, 'create'])->name('create');
                Route::post('/', [DestinationController::class, 'store'])->name('store');
                Route::post('/upload-image', [DestinationController::class, 'uploadImage'])->name('upload-image');
                Route::get('/{destination}/edit', [DestinationController::class, 'edit'])->name('edit');
                Route::put('/{destination}', [DestinationController::class, 'update'])->name('update');
                Route::delete('/{destination}', [DestinationController::class, 'destroy'])->name('destroy');
                Route::post('/{destination}/ban', [DestinationController::class, 'ban'])->name('ban');
                Route::post('/{destination}/unban', [DestinationController::class, 'unban'])->name('unban');
            });

        // Hotel Management
        Route::prefix('hotel')
            ->name('hotels.')
            ->group(function () {
                Route::get('/', [HotelController::class, 'index'])->name('index');
                Route::get('/all', [HotelController::class, 'getAll'])->name('all');
                Route::get('/create', [HotelController::class, 'create'])->name('create');
                Route::post('/', [HotelController::class, 'store'])->name('store');
                Route::post('/upload-image', [HotelController::class, 'uploadImage'])->name('upload-image');
                Route::get('/{hotel}/edit', [HotelController::class, 'edit'])->name('edit');
                Route::put('/{hotel}', [HotelController::class, 'update'])->name('update');
                Route::delete('/{hotel}', [HotelController::class, 'destroy'])->name('destroy');
                Route::post('/{hotel}/ban', [HotelController::class, 'ban'])->name('ban');
                Route::post('/{hotel}/unban', [HotelController::class, 'unban'])->name('unban');
            });

        Route::prefix('restaurant')
            ->name('restaurants.')
            ->group(function () {
                Route::get('/', [RestaurantController::class, 'index'])->name('index');
                Route::get('/all', [RestaurantController::class, 'getAll'])->name('all');
                Route::get('/create', [RestaurantController::class, 'create'])->name('create');
                Route::post('/', [RestaurantController::class, 'store'])->name('store');
                Route::post('/upload-image', [RestaurantController::class, 'uploadImage'])->name('upload-image');
                Route::get('/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('edit');
                Route::put('/{restaurant}', [RestaurantController::class, 'update'])->name('update');
                Route::delete('/{restaurant}', [RestaurantController::class, 'destroy'])->name('destroy');
                Route::post('/{restaurant}/ban', [RestaurantController::class, 'ban'])->name('ban');
                Route::post('/{restaurant}/unban', [RestaurantController::class, 'unban'])->name('unban');
            });
    });

require __DIR__ . '/auth.php';
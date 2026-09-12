<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RealtimeController;
use App\Http\Controllers\Admin\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/destinations', [PublicController::class, 'destinations'])->name('destinations.index');
Route::get('/destinations/{slug}', [PublicController::class, 'destinationShow'])->name('destinations.show');
Route::get('/map', [PublicController::class, 'map'])->name('map');
Route::get('/tours', [PublicController::class, 'tours'])->name('tours.index');
Route::get('/tours/{slug}', [PublicController::class, 'tourShow'])->name('tours.show');
Route::get('/culture', [PublicController::class, 'culture'])->name('culture');

use App\Http\Controllers\ExploreController;
// Explore routes
Route::get('/explore', [ExploreController::class, 'index'])->name('explore');
Route::get('/explore/{city}', [ExploreController::class, 'city'])->name('explore.city');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Tourist Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/my-dashboard', [BookingController::class, 'userDashboard'])->name('user.dashboard');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    
    Route::post('/destinations/{id}/save', [PublicController::class, 'toggleSavePlace'])->name('destinations.save');
    Route::post('/destinations/{id}/review', [PublicController::class, 'storeReview'])->name('destinations.review');


    
    Route::get('/api/realtime/stream', [RealtimeController::class, 'stream'])->name('api.realtime.stream');
    Route::get('/api/realtime/notifications', [RealtimeController::class, 'pollNotifications'])->name('api.realtime.notifications');
    Route::post('/api/realtime/notifications/{id}/read', [RealtimeController::class, 'markRead'])->name('api.realtime.read');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Custom check inside controller or middleware
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Destinations
    Route::get('/destinations', [AdminDashboardController::class, 'destinations'])->name('admin.destinations');
    Route::get('/destinations/create', [AdminDashboardController::class, 'createDestination'])->name('admin.destinations.create');
    Route::post('/destinations', [AdminDashboardController::class, 'storeDestination'])->name('admin.destinations.store');
    Route::get('/destinations/{id}/edit', [AdminDashboardController::class, 'editDestination'])->name('admin.destinations.edit');
    Route::put('/destinations/{id}', [AdminDashboardController::class, 'updateDestination'])->name('admin.destinations.update');
    Route::delete('/destinations/{id}', [AdminDashboardController::class, 'deleteDestination'])->name('admin.destinations.delete');
    
    // Tour Packages
    Route::get('/tours', [AdminDashboardController::class, 'tours'])->name('admin.tours');
    Route::get('/tours/create', [AdminDashboardController::class, 'createTour'])->name('admin.tours.create');
    Route::post('/tours', [AdminDashboardController::class, 'storeTour'])->name('admin.tours.store');
    Route::get('/tours/{id}/edit', [AdminDashboardController::class, 'editTour'])->name('admin.tours.edit');
    Route::put('/tours/{id}', [AdminDashboardController::class, 'updateTour'])->name('admin.tours.update');
    Route::delete('/tours/{id}', [AdminDashboardController::class, 'deleteTour'])->name('admin.tours.delete');

    // Bookings
    Route::get('/bookings', [AdminDashboardController::class, 'bookings'])->name('admin.bookings');
    Route::get('/bookings/{id}/edit', [AdminDashboardController::class, 'editBooking'])->name('admin.bookings.edit');
    Route::put('/bookings/{id}', [AdminDashboardController::class, 'updateBooking'])->name('admin.bookings.update');
    Route::post('/bookings/{id}/reject', [AdminDashboardController::class, 'rejectBooking'])->name('admin.bookings.reject');
    Route::put('/bookings/{id}/status', [AdminDashboardController::class, 'updateBookingStatus'])->name('admin.bookings.status');
});

Route::get('/api/cities/search', [PublicController::class, 'searchCities'])->name('api.cities.search');


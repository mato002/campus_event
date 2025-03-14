<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\userDashboardController;
use App\Http\Controllers\FeedbackController ;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SearchController;





 // User-facing event controller


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// === USER-FACING ROUTES === //
Route::get('/home', [userDashboardController::class, 'index'])->name('home');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::post('/events/{id}/register', [EventController::class, 'register'])->name('events.register');
Route::get('/mybookings', [EventController::class, 'myBookings'])->name('user.mybookings');


// User Dashboard - My Events
Route::middleware('auth')->group(function () {
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.my_events');
});

// Additional User-Facing Pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/faqs', function () {
    return view('faqs');
})->name('faqs');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');

// === AUTHENTICATION ROUTES === //
Route::middleware('auth:regular_user')->group(function () {
    // Use the DashboardController for the dashboard route
    Route::get('/dashboard', [userDashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');
    
});


// === ADMIN ROUTES === //
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource routes for Admin Event & Venue Management
    Route::resource('events', AdminEventController::class);
    Route::resource('venues', VenueController::class);
    Route::get('manage-users', [UserController::class, 'index'])->name('manage-users');
    Route::delete('manage-users/{id}', [UserController::class, 'destroy'])->name('manage-users.destroy');
    
    



    // Additional Admin Functionalities
    Route::delete('events/{event}', [AdminEventController::class, 'destroy'])->name('events.destroy');
    Route::delete('venues/{venue}', [VenueController::class, 'destroy'])->name('venues.destroy');
    
    // Admin Profile Management
    Route::get('profile', [AdminProfileController::class, 'show'])->name('profile');
    Route::post('profile/update', [AdminProfileController::class, 'updateProfilePicture'])->name('profile.update');
    Route::post('profile/upload', [AdminProfileController::class, 'updateProfilePicture'])->name('profile.upload');

    // Admin Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('settings/backup', [SettingsController::class, 'backup'])->name('settings.backup');
    Route::post('settings/restore', [SettingsController::class, 'restore'])->name('settings.restore');
    Route::post('settings/test_email', [SettingsController::class, 'testEmail'])->name('settings.testEmail');
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::delete('/admin/bookings/cancel/{eventId}/{userId}', [AdminBookingController::class, 'cancelBooking'])
    ->name('cancel.booking');


});

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::delete('/admin/events/{id}', [EventController::class, 'destroy'])->name('admin.events.destroy');




// Regular User Login
Route::get('/user/login', [UserLoginController::class, 'showLoginForm'])->name('user.login');
Route::post('/user/login', [UserLoginController::class, 'login']);
Route::post('/user/logout', [UserLoginController::class, 'logout'])->name('user.logout');


// Regular User Registration
Route::get('/user/register', [UserRegisterController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/user/register', [UserRegisterController::class, 'register']);

// Regular User Password Reset
Route::get('/user/password/reset', [PasswordResetController::class, 'showResetForm'])->name('user.password.request');
Route::post('/user/password/email', [PasswordResetController::class, 'sendResetLink'])->name('user.password.email');
Route::post('/user/password/reset', [PasswordResetController::class, 'reset']);


Route::middleware('auth:regular_user')->group(function () {
    Route::get('/user/profile', [UserProfileController::class, 'index'])->name('user.profile');
    Route::get('/user/bookings', [UserProfileController::class, 'myBookings'])->name('user.bookings');
    Route::get('/user/profile/edit', [UserProfileController::class, 'edit'])->name('user.edit_profile');
    Route::post('user/profile/update', [UserProfileController::class, 'update'])->name('user.update_profile');



});


Route::get('/search', [SearchController::class, 'search'])->name('search');


Route::middleware(['auth:regular_user'])->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
    Route::POST('/book-event/{eventId}', [EventController::class, 'bookEvent'])->name('book.event');
    Route::get('/mybookings', [EventController::class, 'myBookings'])->name('my.bookings');
    Route::delete('/cancel-booking/{eventId}', [EventController::class, 'cancelBooking'])->name('cancel.booking');
    Route::post('/feedback', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');
    Route::post('events/{event}/feedback', [FeedbackController::class, 'store'])->name('event.feedback.store');


});



require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\userDashboardController;
use App\Http\Controllers\FeedbackController;
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
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\ContactController;


/*
|--------------------------------------------------------------------------
| USER-FACING ROUTES
|--------------------------------------------------------------------------
*/

// Public pages
Route::get('/home', [userDashboardController::class, 'index'])->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/faqs', fn() => view('faqs'))->name('faqs');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::get('/categories', fn() => view('categories.index'))->name('categories.index');



// Public event pages
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// User Dashboard Pages - require authentication & verification
Route::middleware(['auth:regular_user', 'verified_user'])->group(function () {
    Route::get('/dashboard', [userDashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.my_events');
    Route::get('/mybookings', [EventController::class, 'myBookings'])->name('my.bookings');
    // Route for storing event feedback
Route::post('/event/{event}/feedback', [FeedbackController::class, 'store'])->name('event.feedback.store');


    // Profile routes
    Route::get('/user/profile', [UserProfileController::class, 'index'])->name('user.profile');
    Route::get('/user/profile/edit', [UserProfileController::class, 'edit'])->name('user.edit_profile');
    Route::post('/user/profile/update', [UserProfileController::class, 'update'])->name('user.update_profile');
    Route::get('/user/bookings', [UserProfileController::class, 'myBookings'])->name('user.bookings');

    // Event actions
    Route::post('/events/{id}/register', [EventController::class, 'register'])->name('events.register');
    Route::post('/book-event/{eventId}', [EventController::class, 'bookEvent'])->name('book.event');
    Route::delete('/cancel-booking/{eventId}', [EventController::class, 'cancelBooking'])->name('cancel.booking');
    Route::get('/categories', [UserCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [UserCategoryController::class, 'eventsByCategory'])->name('events.byCategory');
    });

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES FOR REGULAR USERS
|--------------------------------------------------------------------------
*/

// Registration (Step 1)
Route::get('/user/register', [UserRegisterController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/user/register', [UserRegisterController::class, 'register']);
// Route to show the contact form (GET method)
Route::get('/contact/form', [ContactController::class, 'showForm'])->name('contact.form');

// Route to handle form submission (POST method)
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
Route::get('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');



// Verification (Step 2)
Route::get('/user/verify-email', [VerificationController::class, 'showVerificationForm'])->name('verification.notice');
Route::post('/user/verify-email', [VerificationController::class, 'verify'])->name('verification.check');
Route::post('/resend-verification-code', [VerificationController::class, 'resend'])->name('verification.resend');
Route::post('/verify-code', [VerificationController::class, 'verify'])->name('user.verify.code');

// Login (Step 3)
Route::get('/user/login', [UserLoginController::class, 'showLoginForm'])->name('user.login');
Route::post('/user/login', [UserLoginController::class, 'login']);
Route::post('/user/logout', [UserLoginController::class, 'logout'])->name('user.logout');

/*
|--------------------------------------------------------------------------
| PASSWORD RESET ROUTES FOR REGULAR USERS
|--------------------------------------------------------------------------
*/
Route::get('/user/password/reset', [PasswordResetController::class, 'showResetForm'])->name('user.password.request');
Route::post('/user/password/email', [PasswordResetController::class, 'sendResetLink'])->name('user.password.email');
Route::post('/user/password/reset', [PasswordResetController::class, 'reset']);

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (AUTH REQUIRED)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Event & Venue Management
    Route::resource('events', AdminEventController::class);
    Route::resource('venues', VenueController::class);
    Route::resource('categories',CategoryController::class);


    // User Management
    Route::get('manage-users', [UserController::class, 'index'])->name('manage-users');
    Route::delete('manage-users/{id}', [UserController::class, 'destroy'])->name('manage-users.destroy');

    // Admin Profile
    Route::get('profile', [AdminProfileController::class, 'show'])->name('profile');
    Route::post('profile/update', [AdminProfileController::class, 'updateProfilePicture'])->name('profile.update');
    Route::post('profile/upload', [AdminProfileController::class, 'updateProfilePicture'])->name('profile.upload');

    // Settings & Backups
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('settings/backup', [SettingsController::class, 'backup'])->name('settings.backup');
    Route::post('settings/restore', [SettingsController::class, 'restore'])->name('settings.restore');
    Route::post('settings/test_email', [SettingsController::class, 'testEmail'])->name('settings.testEmail');

    // Bookings
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::delete('/admin/bookings/cancel/{eventId}/{userId}', [AdminBookingController::class, 'cancelBooking'])->name('cancel.booking');
});

/*
|--------------------------------------------------------------------------
| MISCELLANEOUS ROUTES
|--------------------------------------------------------------------------
*/

// Logout for admins
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Search functionality
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Test email (optional debug route)
Route::get('/test-email', function () {
    Mail::raw('This is a test email from Campus Event Management System.', function ($message) {
        $message->to('mathiasodhis@gmail.com')->subject('Test Email');
    });

    return 'Test email sent!';
});

// Laravel Breeze/Auth routes (if any)
require __DIR__ . '/auth.php';

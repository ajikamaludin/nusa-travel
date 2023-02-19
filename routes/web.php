<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FastboatPlaceController;
use App\Http\Controllers\FastboatTrackController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Website\BlogController;
use App\Http\Controllers\Website\LandingController;
use App\Http\Controllers\Website\LoginController;
use App\Http\Controllers\Website\SignUpController;
use App\Http\Controllers\Website\PageController;
use App\Http\Middleware\VisitorCounter;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(VisitorCounter::class)->group(function () {
    // Landing
    Route::get('/',[LandingController::class, 'index'])->name('home.index');

    // Blog
    Route::get('/blog',[BlogController::class, 'index'])->name('blog.index');

    // Detail Blog
    Route::get('/blog/post',[BlogController::class, 'show'])->name('blog.post');

    // Package Tours
    // Car Rentals
    // Fastboat

    // Login / Register
    Route::get('/login', [LoginController::class, 'index'])->name('customer.login');
    Route::get('/signup',[SignUpController::class, 'index'])->name('customer.signup');
    Route::post('/signup',[SignUpController::class, 'store']);
    Route::get('/customer/{customer:id}/active',[SignUpController::class, 'active'])->name('customer.active');


    Route::middleware('auth:customer')->group(function(){
        // Profile
        // Order
    });

    // Page
    Route::get('/page/{page:key}', [PageController::class, 'index'])->name('page.index');
});

Route::prefix('travel')->group(function() {
    Route::get('/', fn() => redirect()->route('login'));

    Route::get('in-dev', [GeneralController::class, 'indev'])->name('in.dev');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::middleware('auth:web')->group(function(){
        // Dashboard
        Route::get('/dashboard', [GeneralController::class, 'index'])->name('dashboard');

        // Blog
        // Page

        // Setting

        // Package Tours
        // Car Rentals

        // Fastboat Place
        Route::get('/fastboat/places', [FastboatPlaceController::class, 'index'])->name('fastboat.place.index');
        Route::post('/fastboat/places', [FastboatPlaceController::class, 'store'])->name('fastboat.place.store');
        Route::put('/fastboat/places/{place}', [FastboatPlaceController::class, 'update'])->name('fastboat.place.update');
        Route::delete('/fastboat/places/{place}', [FastboatPlaceController::class, 'destroy'])->name('fastboat.place.destroy');
        // Fastboat Track
        Route::get('/fastboat/tracks', [FastboatTrackController::class, 'index'])->name('fastboat.track.index');
        Route::post('/fastboat/tracks', [FastboatTrackController::class, 'store'])->name('fastboat.track.store');
        Route::put('/fastboat/tracks/{track}', [FastboatTrackController::class, 'update'])->name('fastboat.track.update');
        Route::delete('/fastboat/tracks/{track}', [FastboatTrackController::class, 'destroy'])->name('fastboat.track.destroy');
        // Fastboat Order

        // User Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Setting
        Route::get('/setting/general', [SettingController::class, 'general'])->name('setting.general');
        Route::post('/setting/update-general', [SettingController::class, 'updateGeneral'])->name('setting.update-general');
        Route::get('/setting/payment', [SettingController::class, 'payment'])->name('setting.payment');
        Route::post('/setting/update-payment', [SettingController::class, 'updatePayment'])->name('setting.update-payment');
        // User
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::post('/users', [UserController::class, 'store'])->name('user.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        
        // Role
        Route::resource('/roles', RoleController::class);
    });
});
require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Website\LandingController;
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
    Route::get('/',[LandingController::class, 'index']);

    // Blog
    Route::get('/blog', function () {
        return view('blog');
    });

    // Detail Blog
    Route::get('/blog/post', function () {
        return view('blog-post');
    });
    // Page

    // Package Tours
    // Car Rentals
    // Fastboat

    Route::middleware('auth:customer')->group(function(){
        // Profile
        // Order
    });
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
        // Fastboat

        // User Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Setting
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

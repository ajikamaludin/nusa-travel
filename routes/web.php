<?php

use App\Http\Controllers\Website\BlogController;
use App\Http\Controllers\Website\FastboatController;
use App\Http\Controllers\Website\LandingController;
use App\Http\Controllers\Website\LoginController;
use App\Http\Controllers\Website\SignUpController;
use App\Http\Controllers\Website\PageController;
use App\Http\Controllers\Website\ProfileController as CustomerProfileController;
use App\Http\Middleware\GuardCustomer;
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

Route::middleware([VisitorCounter::class, GuardCustomer::class])->group(function () {
    // Blog
    Route::get('/blog',[BlogController::class, 'index'])->name('blog.index');

    // Detail Blog
    Route::get('/blog/{post:slug}',[BlogController::class, 'show'])->name('blog.post');

    // Package Tours
    // Car Rentals
    // Fastboat
    Route::get('/fastboat',[FastboatController::class, 'index'])->name('fastboat.index');

    // Login / Register
    Route::middleware('guest:customer')->group(function(){
        Route::get('/login', [LoginController::class, 'index'])->name('customer.login');
        Route::post('/login', [LoginController::class, 'store']);
        Route::get('/signup',[SignUpController::class, 'index'])->name('customer.signup');
        Route::post('/signup',[SignUpController::class, 'store']);
        Route::get('/customer/{customer:id}/active',[SignUpController::class, 'active'])->name('customer.active');
    });

    Route::middleware('auth:customer')->group(function(){
        // Profile
        Route::get('/profile', [CustomerProfileController::class, 'index'])->name('customer.profile');
        Route::post('/profile/logout', [CustomerProfileController::class, 'destroy'])->name('customer.logout');
        // Order
        Route::get('/fastboat/orders', [FastboatController::class, 'mine'])->name('fastboat.mine');
        Route::post('/fastboat/{track}',[FastboatController::class, 'order'])->name('fastboat.order');
        Route::get('/fastboat/{order}', [FastboatController::class, 'show'])->name('fastboat.show');
    });

    // Page
    Route::get('/page/faq', [PageController::class, 'faq'])->name('page.faq');
    Route::get('/page/{page:key}', [PageController::class, 'show'])->name('page.show');

    // Landing
    Route::get('/{locale?}',[LandingController::class, 'index'])->name('home.index')
        ->whereIn('locale', ['en', 'id']);
});

require __DIR__.'/admin.php';
require __DIR__.'/auth.php';

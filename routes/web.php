<?php

use App\Http\Controllers\Website\CarRentalController;
use App\Http\Controllers\Website\BlogController;
use App\Http\Controllers\Website\FastboatController;
use App\Http\Controllers\Website\LandingController;
use App\Http\Controllers\Website\LoginController;
use App\Http\Controllers\Website\OrderController;
use App\Http\Controllers\Website\SignUpController;
use App\Http\Controllers\Website\PageController;
use App\Http\Controllers\Website\ProfileController as CustomerProfileController;
use App\Http\Controllers\Website\TourPackageController;
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
    // Package Tours
    Route::get('/tour-packages',[TourPackageController::class, 'index'])->name('tour-packages.index');
    Route::get('/tour-packages/{package:slug}',[TourPackageController::class, 'show'])->name('tour-packages.show');

    // Car Rentals
    Route::get('/car-rentals',[CarRentalController::class, 'index'])->name('car.index');

    // Fastboat
    Route::get('/fastboat',[FastboatController::class, 'index'])->name('fastboat');
    
    // Order
    Route::get('/carts', [OrderController::class, 'index'])->name('customer.cart');
    Route::get('/carts/process-payment/{order}', [OrderController::class, 'payment'])->name('customer.process-payment');
    Route::get('/orders',[OrderController::class, 'orders'])->name('customer.orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('customer.order');

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
        Route::post('/profile', [CustomerProfileController::class, 'update']);
        Route::post('/profile/p', [CustomerProfileController::class, 'password'])->name('customer.password');
        Route::post('/profile/logout', [CustomerProfileController::class, 'destroy'])->name('customer.logout');
    });

    // Blog
    Route::get('/page/blog',[BlogController::class, 'index'])->name('blog.index');
    // Detail Blog
    Route::get('page/blog/{post:slug}',[BlogController::class, 'show'])->name('blog.post');
    // Page
    Route::get('/page/gallery', [PageController::class, 'gallery'])->name('page.gallery');
    Route::get('/page/faq', [PageController::class, 'faq'])->name('page.faq');
    Route::get('/page/{page:key}', [PageController::class, 'show'])->name('page.show');

    // Landing
    Route::get('/accept-cookie', [LandingController::class, 'acceptCookie'])->name('accept.cookie');
    Route::get('/{locale?}',[LandingController::class, 'index'])->name('home.index')
        ->whereIn('locale', ['en', 'id']);
});

require __DIR__.'/admin.php';
require __DIR__.'/auth.php';

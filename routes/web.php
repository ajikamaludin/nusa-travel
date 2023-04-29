<?php

use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Website\BlogController;
use App\Http\Controllers\Website\CarRentalController;
use App\Http\Controllers\Website\FastboatController;
use App\Http\Controllers\Website\LandingController;
use App\Http\Controllers\Website\LoginController;
use App\Http\Controllers\Website\OrderController;
use App\Http\Controllers\Website\PageController;
use App\Http\Controllers\Website\ProfileController as CustomerProfileController;
use App\Http\Controllers\Website\SignUpController;
use App\Http\Controllers\Website\TourPackageController;
use App\Http\Middleware\GuardCustomer;
use App\Http\Middleware\VisitorCounter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;
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

// Test Only
/*
Route::get('/test', function () {
    $markdown = new Markdown(view(), config('mail.markdown'));

    $order = Order::find('98ab7336-776f-4f6c-84cc-5008fbedf0ab');

    return $markdown->render('emails.orders.payment', [
        'order' => $order,
        'wait' => $order->created_at->addDay()->format('d M Y H:i'),
    ]);
});
*/
Route::get('/ticket', function () {
    // $pdf = Pdf::loadView('pdf.ticket')->setPaper('latter', 'landscape')->setOption(['dpi' => 400]);
    // return $pdf->stream();
    return view('pdf.ticket');
});

Route::get('/flush', function () {
    Cache::flush();

    return response()->json(['message' => 'cache cleared']);
});

Route::middleware([VisitorCounter::class, GuardCustomer::class])->group(function () {
    // Package Tours
    Route::get('/tour-packages', [TourPackageController::class, 'index'])->name('tour-packages.index');
    Route::get('/tour-packages/{package:slug}', [TourPackageController::class, 'show'])->name('tour-packages.show');

    // Car Rentals
    Route::get('/car-rental-bali', [CarRentalController::class, 'index'])->name('car.index');

    // Fastboat
    Route::get('/fastboat', [FastboatController::class, 'index'])->name('fastboat');
    Route::get('/ekajaya-fastboat', [FastboatController::class, 'ekajayaFastBoat'])->name('ekajaya-fastboat');

    // Order
    Route::get('/carts', [OrderController::class, 'index'])->name('customer.cart');
    Route::get('/carts/fastboat', [OrderController::class, 'fastboat'])->name('customer.cart.fastboat');
    Route::get('/carts/process-payment/{order}', [OrderController::class, 'payment'])->name('customer.process-payment');
    Route::get('/orders', [OrderController::class, 'orders'])->name('customer.orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('customer.order');

    // Login / Register
    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('customer.login');
        Route::post('/login', [LoginController::class, 'store']);
        Route::get('/signup', [SignUpController::class, 'index'])->name('customer.signup');
        Route::post('/signup', [SignUpController::class, 'store']);
        Route::get('/customer/{customer:id}/active', [SignUpController::class, 'active'])->name('customer.active');
    });

    Route::middleware('auth:customer')->group(function () {
        // Profile
        Route::get('/profile', [CustomerProfileController::class, 'index'])->name('customer.profile');
        Route::get('/apitoken', [CustomerProfileController::class, 'apitoken'])->name('customer.apitoken');
        Route::post('/profile', [CustomerProfileController::class, 'update']);
        Route::post('/profile/p', [CustomerProfileController::class, 'password'])->name('customer.password');
        Route::post('/profile/logout', [CustomerProfileController::class, 'destroy'])->name('customer.logout');
    });

    // Blog
    Route::get('/page/blog', [BlogController::class, 'index'])->name('blog.index');
    // Detail Blog
    Route::get('page/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.post');
    // Page
    Route::get('/page/gallery', [PageController::class, 'gallery'])->name('page.gallery');
    Route::get('/page/faq', [PageController::class, 'faq'])->name('page.faq');
    Route::get('/page/{page:key}', [PageController::class, 'show'])->name('page.show');

    // Landing
    Route::get('/accept-cookie', [LandingController::class, 'acceptCookie'])->name('accept.cookie');
    Route::get('/{locale?}', [LandingController::class, 'index'])->name('home.index')
        ->whereIn('locale', ['en', 'id']);

    // Sitemap
    Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
});

require __DIR__.'/admin.php';
require __DIR__.'/auth.php';

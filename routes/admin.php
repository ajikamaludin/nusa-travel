<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FastboatPlaceController;
use App\Http\Controllers\FastboatTrackController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::prefix('travel')->group(function() {
    Route::get('/', fn() => redirect()->route('login'));

    Route::get('in-dev', [GeneralController::class, 'indev'])->name('in.dev');

    Route::middleware('guest:web')->group(function(){
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::middleware('auth:web')->group(function(){
        // Dashboard
        Route::get('/dashboard', [GeneralController::class, 'index'])->name('dashboard');

        // Customer
        Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customer.store');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customer.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');

        // Faq
        Route::get('/faqs', [FaqController::class, 'index'])->name('faq.index');
        Route::get('/faqs/create', [FaqController::class, 'create'])->name('faq.create');
        Route::post('/faqs', [FaqController::class, 'store'])->name('faq.store');
        Route::get('/faqs/{faq}', [FaqController::class, 'edit'])->name('faq.edit');
        Route::post('/faqs/{faq}', [FaqController::class, 'update'])->name('faq.update');
        Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faq.destroy');

        // Tag
        Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
        Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
        Route::post('/gallery/{file}', [GalleryController::class, 'update'])->name('gallery.update');
        Route::delete('/gallery/{file}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

        // Tag
        Route::get('/tags', [TagController::class, 'index'])->name('tag.index');
        Route::post('/tags', [TagController::class, 'store'])->name('tag.store');
        Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tag.update');
        Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tag.destroy');

        // Post
        Route::post('/posts/upload', [GeneralController::class, 'upload'])->name('post.upload');
        Route::get('/posts', [PostController::class, 'index'])->name('post.index');
        Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/posts', [PostController::class, 'store'])->name('post.store');
        Route::get('/posts/{post}', [PostController::class, 'edit'])->name('post.edit');
        Route::post('/posts/{post}', [PostController::class, 'update'])->name('post.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');

        // Page
        Route::get('/pages/{page:key}', [PageController::class, 'edit'])->name('page.edit');
        Route::post('/pages/{page}', [PageController::class, 'update'])->name('page.update');

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

        // Order
        Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('order.edit');
        Route::put('/orders/{order}', [OrderController::class, 'update'])->name('order.update');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
    });
});
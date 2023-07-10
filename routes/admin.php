<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\CarRentalController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepositeAgentController;
use App\Http\Controllers\EkajayaController;
use App\Http\Controllers\EkajayaSubAgentController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FastboatController;
use App\Http\Controllers\FastboatDropoffController;
use App\Http\Controllers\FastboatPickupController;
use App\Http\Controllers\FastboatPlaceController;
use App\Http\Controllers\FastboatTrackAgentController;
use App\Http\Controllers\FastboatTrackController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\GlobaltixAgentController;
use App\Http\Controllers\GlobaltixController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TourPackageController;
use App\Http\Controllers\UnavailableDateController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Support\Facades\Route;

Route::prefix('travel')->middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('/', fn () => redirect()->route('login'));

    Route::get('in-dev', [GeneralController::class, 'indev'])->name('in.dev');

    Route::middleware('guest:web')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::middleware('auth:web')->group(function () {
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

        // Promo
        Route::get('/promos', [PromoController::class, 'index'])->name('promo.index');
        Route::get('/promos/create', [PromoController::class, 'create'])->name('promo.create');
        Route::post('/promos', [PromoController::class, 'store'])->name('promo.store');
        Route::get('/promos/{promo}', [PromoController::class, 'edit'])->name('promo.edit');
        Route::post('/promos/{promo}', [PromoController::class, 'update'])->name('promo.update');
        Route::delete('/promos/{promo}', [PromoController::class, 'destroy'])->name('promo.destroy');

        // Gallery
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

        // Package Tours
        Route::get('/packages', [TourPackageController::class, 'index'])->name('packages.index');
        Route::get('/packages/create', [TourPackageController::class, 'create'])->name('packages.create');
        Route::post('/packages', [TourPackageController::class, 'store'])->name('packages.store');
        Route::get('/packages/{package}', [TourPackageController::class, 'edit'])->name('packages.edit');
        Route::post('/packages/{package}', [TourPackageController::class, 'update'])->name('packages.update');
        Route::delete('/packages/{package}', [TourPackageController::class, 'destroy'])->name('packages.destroy');

        // Car Rentals
        Route::get('/car-rentals', [CarRentalController::class, 'index'])->name('car-rental.index');
        Route::post('/car-rentals', [CarRentalController::class, 'store'])->name('car-rental.store');
        Route::put('/car-rentals/{car}', [CarRentalController::class, 'update'])->name('car-rental.update');
        Route::delete('/car-rentals/{car}', [CarRentalController::class, 'destroy'])->name('car-rental.destroy');

        // Fastboat Dropoff
        Route::get('/fastboat/dropoff', [FastboatDropoffController::class, 'index'])->name('fastboat.dropoff.index');
        Route::post('/fastboat/dropoff', [FastboatDropoffController::class, 'store'])->name('fastboat.dropoff.store');
        Route::put('/fastboat/dropoff/{dropoff}', [FastboatDropoffController::class, 'update'])->name('fastboat.dropoff.update');
        Route::delete('/fastboat/dropoff/{dropoff}', [FastboatDropoffController::class, 'destroy'])->name('fastboat.dropoff.destroy');

        // Fastboat Pickup
        Route::get('/fastboat/pickup', [FastboatPickupController::class, 'index'])->name('fastboat.pickup.index');
        Route::post('/fastboat/pickup', [FastboatPickupController::class, 'store'])->name('fastboat.pickup.store');
        Route::put('/fastboat/pickup/{pickup}', [FastboatPickupController::class, 'update'])->name('fastboat.pickup.update');
        Route::delete('/fastboat/pickup/{pickup}', [FastboatPickupController::class, 'destroy'])->name('fastboat.pickup.destroy');

        // Fastboat Place
        Route::get('/fastboat/places', [FastboatPlaceController::class, 'index'])->name('fastboat.place.index');
        Route::post('/fastboat/places', [FastboatPlaceController::class, 'store'])->name('fastboat.place.store');
        Route::put('/fastboat/places/{place}', [FastboatPlaceController::class, 'update'])->name('fastboat.place.update');
        Route::delete('/fastboat/places/{place}', [FastboatPlaceController::class, 'destroy'])->name('fastboat.place.destroy');

        // Fastboat Track
        Route::get('/fastboat/tracks', [FastboatTrackController::class, 'index'])->name('fastboat.track.index');
        Route::get('/fastboat/tracks/create', [FastboatTrackController::class, 'create'])->name('fastboat.track.create');
        Route::post('/fastboat/tracks', [FastboatTrackController::class, 'store'])->name('fastboat.track.store');
        Route::get('/fastboat/tracks/{group}', [FastboatTrackController::class, 'edit'])->name('fastboat.track.edit');
        Route::put('/fastboat/tracks/{group}', [FastboatTrackController::class, 'update'])->name('fastboat.track.update');
        Route::delete('/fastboat/tracks/{group}', [FastboatTrackController::class, 'destroy'])->name('fastboat.track.destroy');

        // Fastboat
        Route::get('/fastboat', [FastboatController::class, 'index'])->name('fastboat.fastboat.index');
        Route::get('/fastboat/create', [FastboatController::class, 'create'])->name('fastboat.fastboat.create');
        Route::post('/fastboat', [FastboatController::class, 'store'])->name('fastboat.fastboat.store');
        Route::get('/fastboat/{fastboat}', [FastboatController::class, 'edit'])->name('fastboat.fastboat.edit');
        Route::post('/fastboat/{fastboat}', [FastboatController::class, 'update'])->name('fastboat.fastboat.update');
        Route::delete('/fastboat/{fastboat}', [FastboatController::class, 'destroy'])->name('fastboat.fastboat.destroy');

        // User Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Setting
        Route::get('/setting/general', [SettingController::class, 'general'])->name('setting.general');
        Route::post('/setting/update-general', [SettingController::class, 'updateGeneral'])->name('setting.update-general');
        Route::get('/setting/payment', [SettingController::class, 'payment'])->name('setting.payment');
        Route::post('/setting/update-payment', [SettingController::class, 'updatePayment'])->name('setting.update-payment');
        Route::get('/setting/ekajaya', [SettingController::class, 'ekajaya'])->name('setting.ekajaya');
        Route::post('/setting/update-ekajaya', [SettingController::class, 'updateEkajaya'])->name('setting.update-ekajaya');
        Route::get('/setting/globaltix', [SettingController::class, 'globaltix'])->name('setting.globaltix');
        Route::post('/setting/update-globaltix', [SettingController::class, 'updateGlobaltix'])->name('setting.update-globaltix');

        // User
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::post('/users', [UserController::class, 'store'])->name('user.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        // Role
        Route::resource('/roles', RoleController::class);

        // Calender
        Route::get('/calender', [CalenderController::class, 'index'])->name('calender.index');
        Route::get('/calender/create', [CalenderController::class, 'create'])->name('calender.create');
        Route::post('/calender', [CalenderController::class, 'store'])->name('calender.store');
        Route::get('/calender/{date}', [CalenderController::class, 'edit'])->name('calender.edit');
        Route::put('/calender/{date}', [CalenderController::class, 'update'])->name('calender.update');
        Route::delete('/calender/{date}', [CalenderController::class, 'destroy'])->name('calender.destroy');

        // Order
        Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('order.create');
        Route::post('/orders/create', [OrderController::class, 'store'])->name('order.store');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('order.edit');
        Route::put('/orders/{order}', [OrderController::class, 'update'])->name('order.update');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
        Route::get('/orders/{order}/fastboat/ticket/download', [OrderController::class, 'ticket_download'])->name('order.ticket.download');

        //Agen
        Route::get('/agent', [AgentController::class, 'index'])->name('agent.index');
        Route::post('/agent', [AgentController::class, 'store'])->name('agent.store');
        Route::put('/agent/{agent}', [AgentController::class, 'update'])->name('agent.update');
        Route::delete('/agent/{agent}', [AgentController::class, 'destroy'])->name('agent.destroy');

        // Price Agent
        Route::get('/price-agent', [FastboatTrackAgentController::class, 'index'])->name('price-agent.index');
        Route::get('/price-agent/tracks/create', [FastboatTrackAgentController::class, 'create'])->name('price-agent.track.create');
        Route::post('/price-agent/tracks', [FastboatTrackAgentController::class, 'store'])->name('price-agent.track.store');
        Route::get('/price-agent/tracks/{group}', [FastboatTrackAgentController::class, 'edit'])->name('price-agent.trackagent.edit');
        Route::put('/price-agent/tracks/{group}', [FastboatTrackAgentController::class, 'update'])->name('price-agent.track.update');
        Route::delete('/price-agent/tracks/{group}', [FastboatTrackAgentController::class, 'destroy'])->name('price-agent.track.destroy');

        // Unavailable Date
        Route::get('/unavailable-date', [UnavailableDateController::class, 'index'])->name('unavailable-date.index');
        Route::post('/unavailable-date', [UnavailableDateController::class, 'store'])->name('unavailable-date.store');
        Route::put('/unavailable-date/{date}', [UnavailableDateController::class, 'update'])->name('unavailable-date.update');
        Route::delete('/unavailable-date/{date}', [UnavailableDateController::class, 'destroy'])->name('unavailable-date.destroy');

        // Globaltix
        Route::get('/globaltix-fastboat', [GlobaltixController::class, 'index'])->name('fastboat.globaltix.index');
        Route::get('/globaltix-fastboat/create', [GlobaltixController::class, 'create'])->name('fastboat.globaltix.create');
        Route::post('/globaltix-fastboat', [GlobaltixController::class, 'store'])->name('fastboat.globaltix.store');
        Route::get('/globaltix-fastboat/{track}', [GlobaltixController::class, 'edit'])->name('fastboat.globaltix.edit');
        Route::post('/globaltix-fastboat/{track}', [GlobaltixController::class, 'update'])->name('fastboat.globaltix.update');
        Route::delete('/globaltix-fastboat/{track}', [GlobaltixController::class, 'destroy'])->name('fastboat.globaltix.destroy');

        // Ekajaya
        Route::get('/ekajaya-fastboat', [EkajayaController::class, 'index'])->name('fastboat.ekajaya.index');
        Route::get('/ekajaya-fastboat/create', [EkajayaController::class, 'create'])->name('fastboat.ekajaya.create');
        Route::post('/ekajaya-fastboat', [EkajayaController::class, 'store'])->name('fastboat.ekajaya.store');
        Route::get('/ekajaya-fastboat/{track}', [EkajayaController::class, 'edit'])->name('fastboat.ekajaya.edit');
        Route::post('/ekajaya-fastboat/{track}', [EkajayaController::class, 'update'])->name('fastboat.ekajaya.update');
        Route::delete('/ekajaya-fastboat/{track}', [EkajayaController::class, 'destroy'])->name('fastboat.ekajaya.destroy');

        //Globaltix Agen Price
        Route::get('/globaltix-price-agent', [GlobaltixAgentController::class, 'index'])->name('globaltix-price-agent.index');
        Route::post('/globaltix-price-agent', [GlobaltixAgentController::class, 'store'])->name('globaltix-price-agent.store');
        Route::put('/globaltix-price-agent/{trackAgent}', [GlobaltixAgentController::class, 'update'])->name('globaltix-price-agent.update');
        Route::delete('/globaltix-price-agent/{trackAgent}', [GlobaltixAgentController::class, 'destroy'])->name('globaltix-price-agent.destroy');

        //Deposite Agent
        Route::get('/deposite-agent', [DepositeAgentController::class, 'index'])->name('deposite-agent.index');
        Route::post('/deposite-agent', [DepositeAgentController::class, 'store'])->name('deposite-agent.store');
        Route::delete('/deposite-agent/{history}', [DepositeAgentController::class, 'destroy'])->name('deposite-agent.destroy');

        //Ekajaya Agen Price
        Route::get('/ekajaya-price-agent', [EkajayaSubAgentController::class, 'index'])->name('ekajaya-price-agent.index');
        Route::post('/ekajaya-price-agent', [EkajayaSubAgentController::class, 'store'])->name('ekajaya-price-agent.store');
        Route::put('/ekajaya-price-agent/{trackAgent}', [EkajayaSubAgentController::class, 'update'])->name('ekajaya-price-agent.update');
        Route::delete('/ekajaya-price-agent/{trackAgent}', [EkajayaSubAgentController::class, 'destroy'])->name('ekajaya-price-agent.destroy');
    });
});

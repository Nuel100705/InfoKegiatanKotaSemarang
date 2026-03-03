<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\EventReminderController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/kategori/{slug}', [PublicController::class, 'category'])->name('category.show');
Route::get('/kegiatan/{id}', [PublicController::class, 'show'])->name('event.show');
Route::get('/search', [PublicController::class, 'search'])->name('event.search');
Route::post('/save-subscription', [PublicController::class, 'saveSubscription']);
Route::get('/api/notifications/upcoming', [PublicController::class, 'checkUpcomingEvents']);
Route::post('/api/push-subscribe', [PublicController::class, 'savePushSubscription']);

/*
|--------------------------------------------------------------------------
| ADMIN LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class,'login'])->name('admin.login');
Route::post('/admin/login', [AuthController::class,'authenticate']);
Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');;
Route::get('/profile', [AuthController::class, 'profile'])->name('admin.profile');
Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('admin.profile.update');


/*
|--------------------------------------------------------------------------
| ADMIN PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('admin.auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::resource('categories', CategoryController::class);
    Route::resource('events', EventController::class);

});

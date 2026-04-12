<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;

use App\Http\Controllers\Owner\BusinessController as OwnerBusinessController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/districts/{district}/sub-areas', [DistrictController::class, 'subAreas']);
Route::get('/search', [BusinessController::class, 'search'])->name('business.search');
Route::get('/business/{business}', [BusinessController::class, 'show'])->name('business.show');
Route::get('/category/{category}', [BusinessController::class, 'category'])->name('business.category');

Route::post('/favorites/{business}/toggle', [FavoriteController::class, 'toggle'])->middleware('auth')->name('favorites.toggle');
Route::post('/business/{business}/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');

Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/businesses', [OwnerBusinessController::class, 'index'])->name('businesses.index');
    Route::get('/businesses/create', [OwnerBusinessController::class, 'create'])->name('businesses.create');
    Route::post('/businesses', [OwnerBusinessController::class, 'store'])->name('businesses.store');
    Route::get('/businesses/{business}/edit', [OwnerBusinessController::class, 'edit'])->name('businesses.edit');
    Route::put('/businesses/{business}', [OwnerBusinessController::class, 'update'])->name('businesses.update');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

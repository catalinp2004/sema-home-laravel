<?php

use App\Http\Controllers\Api\AvailabilityController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Simple API endpoint for the front-end to fetch availability snapshot by rooms filter
Route::get('/availability', [AvailabilityController::class, 'index'])->name('apartments.availability');

require __DIR__.'/auth.php';

// Secure the entire site behind login and route pages to invokable controllers
Route::middleware('auth')->group(function () {
    Route::get('/', \App\Http\Controllers\Pages\HomeController::class)->name('home');
    Route::get('/proiect', \App\Http\Controllers\Pages\ProjectController::class)->name('project');
    Route::get('/localizare', \App\Http\Controllers\Pages\LocationController::class)->name('location');
    Route::get('/dezvoltator', \App\Http\Controllers\Pages\DeveloperController::class)->name('developer');
    Route::get('/apartamente', \App\Http\Controllers\Pages\ApartmentsController::class)->name('apartments');
    Route::get('/contact', \App\Http\Controllers\Pages\ContactController::class)->name('contact');

    // Static policy pages
    Route::get('/politica-de-cookies', \App\Http\Controllers\Pages\CookiesController::class)->name('cookies');
    Route::get('/politica-de-confidentialitate', \App\Http\Controllers\Pages\PrivacyController::class)->name('privacy');
    Route::get('/date-personale', \App\Http\Controllers\Pages\PersonalDataController::class)->name('personal.data');
    
    // Building, floor, apartment detail routes
    Route::get('/{building:slug}', \App\Http\Controllers\Pages\BuildingController::class)->name('building.show');
    Route::get('/{building:slug}/{floor:slug}', \App\Http\Controllers\Pages\FloorController::class)->name('floor.show');
    Route::get('/{building:slug}/{floor:slug}/{apartment:friendly_id}', \App\Http\Controllers\Pages\ApartmentController::class)->name('apartment.show');
});

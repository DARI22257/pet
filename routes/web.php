<?php

use App\Http\Controllers\PetController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Shelter\ShelterPetController;
use App\Http\Controllers\Shelter\ShelterApplicationController;
use App\Http\Controllers\Shelter\PetPhotoController;  // ← ЭТУ СТРОКУ ДОБАВИТЬ
use App\Http\Controllers\Volunteer\VolunteerDashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Публичные маршруты
Route::get('/', [PetController::class, 'index'])->name('pets.index');
Route::get('/pets/{pet:slug}', [PetController::class, 'show'])->name('pets.show');

// Аутентифицированные маршруты
Route::middleware('auth')->group(function () {
    // Заявки на усыновление
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::post('/apply/{pet}', [ApplicationController::class, 'store'])->name('apply');
        Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('my');
	Route::get('/{application}', [ApplicationController::class, 'show'])->name('show');
    });

    // Волонтёр
    Route::prefix('volunteer')->name('volunteer.')->middleware('can:be-volunteer')->group(function () {
        Route::get('/dashboard', [VolunteerDashboardController::class, 'index'])->name('dashboard');
    });

    // Управление питомцами
  Route::prefix('shelter')->name('shelter.')->middleware('can:manage-pets')->group(function () {
    Route::resource('pets', ShelterPetController::class);
    
    // Маршруты для фото (добавить ЭТИ три строки)
    Route::post('pets/{pet}/photos', [PetPhotoController::class, 'store'])->name('pets.photos.store');
    Route::delete('pets/{pet}/photos/{photo}', [PetPhotoController::class, 'destroy'])->name('pets.photos.destroy');
    Route::put('pets/{pet}/photos/{photo}/primary', [PetPhotoController::class, 'setPrimary'])->name('pets.photos.primary');
    
    Route::get('/applications', [ShelterApplicationController::class, 'index'])->name('applications.index');
    Route::post('/applications/{application}/approve', [ShelterApplicationController::class, 'approve'])->name('applications.approve');
    Route::post('/applications/{application}/reject', [ShelterApplicationController::class, 'reject'])->name('applications.reject');
});


    // Админка
    Route::prefix('admin')->name('admin.')->middleware('can:access-admin-panel')->group(function () {
        Route::resource('categories', AdminCategoryController::class);
    });
});

require __DIR__.'/auth.php';

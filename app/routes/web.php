<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\ShelterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackController;
use Inertia\Inertia;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Staffs
    Route::controller(StaffController::class)
    ->prefix('/staffs')
    ->middleware(['role:admin'])
    ->group(function() {
        Route::get('/', 'display')->name('staffs.display');
        Route::get('/index', 'index')->name('staffs.index');
        Route::get('/create', 'create')->name('staffs.create');
        Route::post('/store', 'store')->name('staffs.store');
        Route::get('/show', 'show')->name('staffs.show');
        Route::get('/show', 'edit')->name('staffs.edit');
        Route::put('/update', 'update')->name('staffs.update');
        Route::delete('/delete', 'delete')->name('staffs.delete');
        Route::get('/count', 'count')->name('staffs.count');
        Route::post('/restore', 'restore')->name('staffs.restore');
        Route::delete('/forcedelete', 'forceDelete')->name('staffs.forceDelete');
    });

    // Animals
    Route::controller(AnimalController::class)
    ->prefix('/animals')
    ->group(function() {
        Route::get('/count', 'count')->name('animals.count');

        Route::middleware(['role:staff'])->group(function() {
            Route::get('/', 'display')->name('animals.display');
            Route::get('/index', 'index')->name('animals.index');
            Route::get('/create', 'create')->name('animals.create');
            Route::post('/store', 'store')->name('animals.store');
            Route::get('/show', 'show')->name('animals.show');
            Route::get('/edit', 'edit')->name('animals.edit');
            Route::put('/update', 'update')->name('animals.update');
            Route::delete('/delete', 'delete')->name('animals.delete');
            Route::post('/restore', 'restore')->name('animals.restore');
            Route::delete('/forcedelete', 'forceDelete')->name('animals.forceDelete');
            Route::get('/getadoptedanimals', 'getAdoptedAnimals')->name('animals.getAdoptedAnimals');
        });
        
    });

    //Appointments
    Route::controller(AppointmentController::class)
    ->prefix('/appointments')
    ->middleware(['role:staff'])
    ->group(function() {
        Route::get('/', 'display')->name('appointments.display');
        Route::get('/index', 'index')->name('appointments.index');
        Route::get('/create', 'create')->name('appointments.create');
        Route::post('/store', 'store')->name('appointments.store');
        Route::get('/show', 'show')->name('appointments.show');
        Route::get('/show', 'edit')->name('appointments.edit');
        Route::put('/update', 'update')->name('appointments.update');
        Route::delete('/delete', 'delete')->name('appointments.delete');
        Route::get('/count', 'count')->name('appointments.count');
        Route::post('/restore', 'restore')->name('appointments.restore');
        Route::delete('/forcedelete', 'forceDelete')->name('appointments.forceDelete');
    });

    // Shelters
    Route::controller(ShelterController::class)
    ->prefix('/shelters')
    ->name('shelters.')
    ->group(function() {

        Route::get('/index', 'index')->name('index');
        Route::get('/show', 'show')->name('show');

        Route::middleware(['role:admin'])->group(function() {
            Route::get('/', 'display')->name('display');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::delete('/delete', 'delete')->name('delete');
            Route::get('/count', 'count')->name('count');
            Route::post('/restore', 'restore')->name('restore');
            Route::delete('/forcedelete', 'forceDelete')->name('forceDelete');
        });
        
    });

    //Adoptions
    Route::controller(AdoptionController::class)
    ->prefix('/adoptions')
    ->middleware(['role:staff'])
    ->group(function() {
        Route::get('/', 'display')->name('adoptions.display');
        Route::get('/index', 'index')->name('adoptions.index');
        Route::get('/count', 'count')->name('adoptions.count');
    });

    // Tracks
    Route::controller(MonitorController::class)
    ->prefix('/monitor')
    ->name('monitor.')
    ->middleware(['role:staff'])
    ->group(function() {
        Route::get('/', 'display')->name('display');
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/show', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/update', 'update')->name('update');
        Route::delete('/delete', 'delete')->name('delete');
        Route::post('/restore', 'restore')->name('restore');
        Route::delete('/forcedelete', 'forceDelete')->name('forceDelete');
        Route::get('/count', 'count')->name('count');
    });

});

Route::prefix('/customer')
->group(function() {
    Route::get('/animals/index', [AnimalController::class, 'index'])->name('customers.animals.index');
    Route::get('/shelters/index', [ShelterController::class, 'index'])->name('customers.shelters.index');
    Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('customers.appointments.store');
    Route::get('/appointments/show', [AppointmentController::class, 'show'])->name('customers.appointments.show');
    Route::get('/shelters/show', [ShelterController::class, 'show'])->name('customers.shelters.show');
});

$customerPages = ['Welcome', 'Donate', 'Adopt', 'Track', 'Contact'];
foreach($customerPages as $page) {
    $route = $page === "Welcome" ? '' : strtolower($page);
    Route::get("/".$route, function () use ($page) {
        return Inertia::render("Customer/{$page}");
    });
}

require __DIR__.'/auth.php';

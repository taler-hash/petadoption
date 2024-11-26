<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdoptionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
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
    });

    // Animals
    Route::controller(AnimalController::class)
    ->prefix('/animals')
    ->middleware(['role:admin|staff'])
    ->group(function() {
        Route::get('/', 'display')->name('animals.display');
        Route::get('/index', 'index')->name('animals.index');
        Route::get('/create', 'create')->name('animals.create');
        Route::post('/store', 'store')->name('animals.store');
        Route::get('/show', 'show')->name('animals.show');
        Route::get('/edit', 'edit')->name('animals.edit');
        Route::put('/update', 'update')->name('animals.update');
        Route::delete('/delete', 'delete')->name('animals.delete');
        Route::get('/count', 'count')->name('animals.count');
    });

    //Appointments
    Route::controller(AppointmentController::class)
    ->prefix('/appointments')
    ->middleware(['role:admin|staff'])
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
    });

    //Adoptions
    Route::controller(AdoptionController::class)
    ->prefix('/adoptions')
    ->middleware(['role:admin|staff'])
    ->group(function() {
        Route::get('/', 'display')->name('adoptions.display');
        Route::get('/index', 'index')->name('adoptions.index');
        Route::get('/count', 'count')->name('adoptions.count');
    });


});

Route::prefix('/customer')
->group(function() {
    Route::get('/animals/index', [AnimalController::class, 'index'])->name('customers.animals.index');
    Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('customers.appointments.store');
    Route::get('/appointments/show', [AppointmentController::class, 'show'])->name('customers.appointments.show');
});

$customerPages = ['Welcome', 'Donate', 'Adopt', 'Track', 'Contact'];
foreach($customerPages as $page) {
    $route = $page === "Welcome" ? '' : strtolower($page);
    Route::get("/".$route, function () use ($page) {
        return Inertia::render("Customer/{$page}");
    });
}

require __DIR__.'/auth.php';

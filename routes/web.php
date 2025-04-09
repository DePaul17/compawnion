<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DisponibilityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeptAnimalController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/vet', function () {
    return view('vet');
});

Route::get('/services', function () {
    return view('services');
}); 

Route::get('/gallery', function () {
    return view('gallery');
});

Route::get('/pricing', function () {
    return view('pricing');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/dashboard', [ProfileController::class, 'store'])->name('profile.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/image', [ProfileController::class, 'deleteImage'])->name('profile.delete-image');

    Route::middleware('client')->group(function () { 
        Route::get('/become-petsitter', [ProfileController::class, 'becomePetsitter'])->name('become-petsitter');
    });

    Route::middleware(['petsitter'])->group(function () { 
        Route::get('/disponibilites', function () { return view('petsitter.disponibility.disponibility-petsitter'); })->name('disponibilites');
        Route::post('/disponibilities', [DisponibilityController::class, 'store'])->name('disponibilities.store');
        Route::put('/disponibilities/{id}', [DisponibilityController::class, 'update'])->name('disponibilities.update');
        Route::delete('/disponibilities/{id}', [DisponibilityController::class, 'destroy'])->name('disponibilities.destroy');

        Route::get('/kept_animals', [KeptAnimalController::class, 'show'])->name('kept_animals');
        Route::post('/kept_animals', [KeptAnimalController::class, 'store'])->name('kept_animals.store');
        Route::get('/list-kept_animals', [KeptAnimalController::class, 'index'])->name('list-kept_animals');
        Route::get('/kept_animals/{keptAnimal}/edit', [KeptAnimalController::class, 'edit'])->name('kept_animals.edit');
        Route::put('/kept_animals/{keptAnimal}', [KeptAnimalController::class, 'update'])->name('kept_animals.update');
        Route::delete('/kept_animals/{keptAnimal}', [KeptAnimalController::class, 'destroy'])->name('kept_animals.destroy');
     });

    //Vérification du profil
    Route::get('/dashboard', [AuthenticatedSessionController::class, '__invoke'])
    ->middleware(['auth'])
    ->name('dashboard');
});

require __DIR__.'/auth.php';

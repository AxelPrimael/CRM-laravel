<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;

// 1. Redirection accueil
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Routes protégées par l'authentification ET le statut du compte
Route::middleware(['auth', 'check.status'])->group(function () {

    // Dashboard accessible à tous les utilisateurs actifs
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- SECTION CONTACTS (Gestion des permissions Spatie) ---
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index')->middleware('permission:contact.view');
        Route::get('/create', [ContactController::class, 'create'])->name('create')->middleware('permission:contact.create');
        Route::post('/', [ContactController::class, 'store'])->name('store')->middleware('permission:contact.create');
        Route::get('/{id}/edit', [ContactController::class, 'edit'])->name('edit')->middleware('permission:contact.edit');
        Route::put('/{id}', [ContactController::class, 'update'])->name('update')->middleware('permission:contact.edit');
        Route::delete('/{id}', [ContactController::class, 'destroy'])->name('destroy')->middleware('permission:contact.delete');
    });

    // --- SECTION PROFIL ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- SECTION ADMIN (Super Admin uniquement) ---
    Route::middleware(['role:Super Admin'])->group(function () {
        // Gestion des utilisateurs
        Route::resource('users', UserController::class);
        
        // Historique des activités
        Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    });

});

require __DIR__.'/auth.php';
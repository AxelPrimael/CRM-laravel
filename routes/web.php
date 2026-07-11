<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;

Route::get('/activities',
    [ActivityController::class,'index']
)->name('activities.index');

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/activities', [
    ActivityController::class,
    'index'
])
->middleware(['auth','role:Super Admin']);

Route::middleware(['auth', 'role:Super Admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::resource('users', UserController::class);


});
Route::middleware([
    'auth',
    'check.status'
])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


});
/*
|--------------------------------------------------------------------------
| USER AUTH
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/contacts', [ContactController::class, 'index'])
        ->middleware('permission:contact.view');

    Route::get('/contacts/create', [ContactController::class, 'create'])
        ->middleware('permission:contact.create');

    Route::post('/contacts', [ContactController::class, 'store'])
        ->middleware('permission:contact.create');

    Route::get('/contacts/{id}/edit', [ContactController::class, 'edit'])
        ->middleware('permission:contact.edit');

    Route::put('/contacts/{id}', [ContactController::class, 'update'])
        ->middleware('permission:contact.edit');

    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])
        ->middleware('permission:contact.delete');


    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


require __DIR__.'/auth.php';
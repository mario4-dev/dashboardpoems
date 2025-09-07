<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotasController;
use App\Models\Notas;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

use App\Models\Contact;

Route::get('dashboard', function () {
    $contactCount = Contact::where('user_id', auth()->id())->count();
    $noteCount = Notas::count();

    return Inertia::render('Dashboard', [
        'contactCount' => $contactCount,
        'noteCount' => $noteCount,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Contact routes - Using resource with only needed methods
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('contacts', ContactController::class)->only([
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ]);
    Route::resource('notas', NotasController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

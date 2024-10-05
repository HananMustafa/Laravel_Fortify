<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NoteController;


Route::get('/', function () {
    return view('welcome');
});


// Two-Factor Setup Route (Requires user to be authenticated)
Route::middleware(['auth', 'verified'])->get('/two-factor-setup', function () {
    return view('auth/two-factor-setup');
})->name('two-factor-setup');



// Client CRUD Routes
Route::middleware(['auth', 'verified'])->get('/client', [ClientController::class, 'index'])->name('client');
Route::middleware(['auth', 'verified'])->get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/client/add', [ClientController::class, 'create'])->name('client.add');
    Route::post('/client/store', [ClientController::class, 'store'])->name('client.store');
    Route::get('/client/edit/{id}', [ClientController::class, 'edit'])->name('client.edit');
    Route::post('/client/update/{id}', [ClientController::class, 'update'])->name('client.update');
    Route::delete('/client/delete/{id}', [ClientController::class, 'destroy'])->name('client.delete');

    // DataTables route to fetch client data
    Route::get('/clients/data', [ClientController::class, 'getData'])->name('clients.data');
});



// Notes Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/client/{clientId}/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/client/{clientId}/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/client/{clientId}/notes/{id}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/client/{clientId}/notes/{id}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/client/{clientId}/notes/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');
});

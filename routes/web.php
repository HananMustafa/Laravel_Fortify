<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


//Home Route (Requires user to be authenticated & verified)
Route::middleware(['auth', 'verified'])->get('/home', function () {
    return view('home');
})->name('home');
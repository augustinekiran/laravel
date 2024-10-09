<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormBuilderController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'test';
});

Route::resource('login', LoginController::class);

Route::middleware(['auth'])->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::post('create-form', [FormBuilderController::class, 'createForm'])->name('form.create');
    Route::post('create-element', [FormBuilderController::class, 'createElement'])->name('element.create');
});

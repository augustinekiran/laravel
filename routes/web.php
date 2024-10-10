<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormBuilderController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'attemptLogin'])->name('login.attempt');
Route::get('form/{form_slug}', [FormBuilderController::class, 'showForm'])->name('form.show');
Route::post('submit', [FormBuilderController::class, 'submitForm'])->name('form.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard.index');
    Route::post('create-form', [FormBuilderController::class, 'createForm'])->name('form.create');
    Route::post('create-element', [FormBuilderController::class, 'createElement'])->name('element.create');
    Route::get('delete-element/{element_id}', [FormBuilderController::class, 'deleteElement'])->name('element.delete');
    Route::post('create-option', [FormBuilderController::class, 'createOption'])->name('option.create');
    Route::get('edit-element/{element_id}', [FormBuilderController::class, 'editElement'])->name('element.edit');
    Route::post('update-element/{element_id}', [FormBuilderController::class, 'updateElement'])->name('element.update');
});

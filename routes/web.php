<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'test';
});

Route::resource('login', LoginController::class);

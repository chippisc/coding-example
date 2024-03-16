<?php

use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\SchulcampusUserController::class)->group(function () {
    Route::get('/', 'index')->name('users.index');
    Route::get('/users/fetch', 'fetch')->name('users.fetch');
    Route::get('/users/{user}/show', 'show')->name('users.show');
});

<?php

use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\SchulcampusUserController::class)->group(function () {
    Route::get('/users/query', 'query')->name('users.query');
    Route::get('/users/{user}/show', 'show')->name('users.show');
});

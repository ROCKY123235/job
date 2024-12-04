<?php

use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'signup']);
Route::post('postsignup', [AuthController::class, 'signupsave']);
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('postlogin', [AuthController::class, 'store'])->name('postlogin');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/homepage', [AuthController::class, 'homepage'])->name('homepage');


Route::middleware(['auth'])->group(function () {

    // Profile page route
    Route::get('/profilepage', [AuthController::class, 'profile'])->name('profilepage');
    Route::get('/edit', [AuthController::class, 'edit']);
    Route::post('/edit', [AuthController::class, 'update']);
    Route::post('/poststore', [AuthController::class, 'up']);
    Route::get('/users/{id}/edits', [AuthController::class, 'edits'])->name('users.edits');
    Route::put('/users/{id}', [AuthController::class, 'updatepost'])->name('users.update');
    Route::delete('post/{id}', [AuthController::class, 'destroy']);


});


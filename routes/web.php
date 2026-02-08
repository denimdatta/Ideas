<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\IdeaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/ideas', [IdeaController::class, 'index'])->name('ideas.index');
    Route::get('/ideas/others', [IdeaController::class, 'others'])->name('ideas.others');
    Route::delete('/ideas', [IdeaController::class, 'destroyAll'])->name('ideas.destroy.all');
    Route::get('/ideas/create', [IdeaController::class, 'create'])->name('ideas.create');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');
    Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('ideas.show');
    Route::get('/ideas/{idea}/edit', [IdeaController::class, 'edit'])->name('ideas.edit');
    Route::patch('/ideas/{idea}', [IdeaController::class, 'update'])->name('ideas.update');
    Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->name('ideas.destroy');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('user.create');
    Route::post('/register', [RegisterController::class, 'store'])->name('user.store');
    Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'email'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->name('login.store')->middleware('guest');
Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth');

<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\IdeaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/ideas', [IdeaController::class, 'index'])->name('ideas.index');
Route::delete('/ideas', [IdeaController::class, 'destroyAll'])->name('ideas.destroy.all');
Route::get('/ideas/create', [IdeaController::class, 'create'])->name('ideas.create');
Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');
Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('ideas.show');
Route::get('/ideas/{idea}/edit', [IdeaController::class, 'edit'])->name('ideas.edit');
Route::patch('/ideas/{idea}', [IdeaController::class, 'update'])->name('ideas.update');
Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->name('ideas.destroy');

Route::get('/register', [RegisterController::class, 'create'])->name('user.create');
Route::post('/register', [RegisterController::class, 'store'])->name('user.store');

Route::get('/login', [SessionController::class, 'create'])->name('user.login');
Route::post('/login', [SessionController::class, 'store'])->name('user.login.store');
Route::delete('/logout', [SessionController::class, 'destroy'])->name('user.logout');

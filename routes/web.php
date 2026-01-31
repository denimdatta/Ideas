<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('ideas');
});

Route::post('/ideas', function () {
    $idea = request('idea');
    session()->push('ideas', $idea);

    return redirect('/');
});

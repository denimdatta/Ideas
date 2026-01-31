<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $ideas = session('ideas', []);

    return view('ideas', [
        'ideas' => $ideas,
    ]);
});

Route::post('/ideas', function () {
    $idea = request('idea');
    session()->push('ideas', $idea);

    return redirect('/');
});

<?php

use App\Enums\IdeaStatus;
use App\Models\Idea;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/ideas', function () {
    $ideas = Idea::all();

    return view('ideas.index', [
        'ideas' => $ideas,
    ]);
});

Route::get('/ideas/{id}', function ($id) {
    $idea = Idea::find($id);

    return view('ideas.show', [
        'idea' => $idea,
    ]);
});

Route::post('/ideas', function () {
    Idea::create([
        'description' => request('idea'),
        'status' => IdeaStatus::PENDING,
    ]);

    return redirect('/');
});

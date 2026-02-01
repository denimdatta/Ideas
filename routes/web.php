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

Route::get('/ideas/{idea}', function (Idea $idea) {
    return view('ideas.show', [
        'idea' => $idea,
    ]);
});

Route::get('/ideas/{idea}/edit', function (Idea $idea) {
    return view('ideas.edit', [
        'idea' => $idea,
    ]);
});

Route::post('/ideas', function () {
    Idea::create([
        'title' => request('title'),
        'description' => request('idea'),
        'status' => IdeaStatus::PENDING,
    ]);

    return redirect('/ideas')
        ->with('success', 'Idea created successfully.');
});

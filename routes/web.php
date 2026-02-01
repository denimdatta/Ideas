<?php

use App\Enums\IdeaStatus;
use App\Models\Idea;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Get Ideas
Route::get('/ideas', function () {
    $ideas = Idea::all()->sortByDesc('created_at');

    return view('ideas.index', [
        'ideas' => $ideas,
    ]);
});

// Get Idea
Route::get('/ideas/{idea}', function (Idea $idea) {
    return view('ideas.show', [
        'idea' => $idea,
    ]);
});

// Update Idea
Route::patch('/ideas/{idea}', function (Idea $idea) {
    $idea->update([
        'title' => request('title'),
        'description' => request('idea'),
        'status' => request('status'),
    ]);

    return redirect('/ideas/' . $idea->id)
        ->with('edit_success', 'Idea updated successfully.');
});

// Create Idea
Route::post('/ideas', function () {
    Idea::create([
        'title' => request('title'),
        'description' => request('idea'),
        'status' => IdeaStatus::PENDING,
    ]);

    return redirect('/ideas')
        ->with('success', 'Idea created successfully.');
});

// Delete Idea
Route::delete('/ideas/{idea}', function (Idea $idea) {
    $idea->delete();

    return redirect('/ideas')
        ->with('delete_success', 'Idea deleted successfully.');
});

// Edit Idea
Route::get('/ideas/{idea}/edit', function (Idea $idea) {
    return view('ideas.edit', [
        'idea' => $idea,
    ]);
});

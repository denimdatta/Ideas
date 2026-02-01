<?php

use App\Enums\IdeaStatus;
use App\Models\Idea;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $ideas = Idea::all();

    return view('ideas', [
        'ideas' => $ideas,
    ]);
});

Route::post('/ideas', function () {
    $idea = Idea::factory()->create();
    $idea->description = request('idea');
    $idea->status = IdeaStatus::OPEN;
    $idea->save();
    
    return redirect('/');
});

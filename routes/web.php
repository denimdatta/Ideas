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
    Idea::create([
        'description' => request('idea'),
        'status' => IdeaStatus::PENDING,
    ]);

    return redirect('/');
});

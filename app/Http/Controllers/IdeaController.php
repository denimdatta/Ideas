<?php

namespace App\Http\Controllers;

use App\Enums\IdeaStatus;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Idea;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ideas = Idea::orderByDesc('created_at')->get();

        return view('ideas.index', [
            'ideas' => $ideas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ideas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request)
    {
        $idea = Idea::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => IdeaStatus::PENDING,
        ]);

        return redirect()
            ->route('ideas.index')
            ->with('create_success', 'Idea created successfully.')
            ->with('idea_id', $idea->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        return view('ideas.show', [
            'idea' => $idea,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        return view('ideas.edit', [
            'idea' => $idea,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        $idea->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => IdeaStatus::from($request->status),
        ]);

        return redirect()
            ->route('ideas.show', $idea)
            ->with('edit_success', 'Idea updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        $idea->delete();

        return redirect()
            ->route('ideas.index')
            ->with('delete_success', 'Idea deleted successfully.');
    }
}

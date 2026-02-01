<?php

namespace App\Http\Controllers;

use App\Enums\IdeaStatus;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
    public function store(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'min:3',
                'max:250',
            ],
            'description' => [
                'required',
                'string',
                'min:20',
            ],
        ]);

        $idea = Idea::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => IdeaStatus::PENDING,
        ]);

        return redirect('/ideas')
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
    public function update(Request $request, Idea $idea)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'min:3',
                'max:250',
            ],
            'description' => [
                'required',
                'string',
                'min:20',
            ],
            'status' => [
                'required',
                'string',
                Rule::in(array_map(fn ($case) => $case->value, IdeaStatus::cases())),
            ],
        ]);

        $idea->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect("/ideas/$idea->id")
            ->with('edit_success', 'Idea updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        $idea->delete();

        return redirect('/ideas')
            ->with('delete_success', 'Idea deleted successfully.');
    }
}

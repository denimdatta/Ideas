<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\IdeaStatus;
use App\Models\Idea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IdeaControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_displays_all_ideas()
    {
        $ideas = Idea::factory()->count(2)->create();

        $response = $this->get('/ideas');

        $response->assertStatus(200);
        $response->assertSee($ideas->first()->title);
        $response->assertSee($ideas->last()->title);
    }

    #[Test]
    public function show_displays_single_idea()
    {
        $idea = Idea::factory()->create();

        $response = $this->get("/ideas/{$idea->id}");

        $response->assertStatus(200);
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
    }

    #[Test]
    public function create_displays_form()
    {
        $response = $this->get('/ideas/create');

        $response->assertStatus(200);
        $response->assertViewIs('ideas.create');
        $response->assertSee('New Idea');
    }

    #[Test]
    public function store_creates_new_idea_with_valid_data()
    {
        $response = $this->post('/ideas', [
            'title' => 'New Idea Title',
            'description' => 'A sufficiently long description for the new idea.',
        ]);

        $response->assertRedirect('/ideas');
        $this->assertDatabaseHas('ideas', [
            'title' => 'New Idea Title',
            'description' => 'A sufficiently long description for the new idea.',
            'status' => IdeaStatus::PENDING->value,
        ]);
    }

    #[Test]
    public function store_fails_with_invalid_data()
    {
        $response = $this->post('/ideas', [
            'title' => 'No', // too short
            'description' => 'Short', // too short
        ]);

        $response->assertSessionHasErrors(['title', 'description']);
        $this->assertDatabaseCount('ideas', 0);
    }

    #[Test]
    public function edit_displays_form()
    {
        $idea = Idea::factory()->create();

        $response = $this->get("/ideas/{$idea->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('ideas.edit');
        $response->assertSee('Update Idea');
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($idea->status->getDisplayName());
    }

    #[Test]
    public function update_modifies_existing_idea_with_valid_data()
    {
        $idea = Idea::factory()->create();

        $response = $this->patch("/ideas/{$idea->id}", [
            'title' => 'Updated Title',
            'description' => 'An updated description that is long enough.',
            'status' => IdeaStatus::COMPLETED->value,
        ]);

        $response->assertRedirect("/ideas/{$idea->id}");
        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
            'title' => 'Updated Title',
            'description' => 'An updated description that is long enough.',
            'status' => IdeaStatus::COMPLETED->value,
        ]);
    }

    #[Test]
    public function update_fails_with_invalid_data_and_keeps_original_values()
    {
        $idea = Idea::factory()->create([
            'title' => 'Original Title',
            'description' => 'Original description that is long enough.',
            'status' => IdeaStatus::PENDING->value,
        ]);

        $response = $this->patch("/ideas/{$idea->id}", [
            'title' => '', // invalid
            'description' => '', // invalid
            'status' => 'invalid_status', // invalid
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'description', 'status']);
        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
            'title' => 'Original Title',
            'description' => 'Original description that is long enough.',
            'status' => IdeaStatus::PENDING->value,
        ]);
    }

    #[Test]
    public function destroy_deletes_the_idea()
    {
        $idea = Idea::factory()->create();

        $response = $this->delete("/ideas/{$idea->id}");

        $response->assertRedirect('/ideas');
        $this->assertDatabaseMissing('ideas', ['id' => $idea->id]);
    }
}

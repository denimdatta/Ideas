<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Str;
use Tests\TestCase;

class IdeaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    #[Test]
    public function index_displays_all_ideas_of_user()
    {
        $loggedInUserIdeas = Idea::factory()->count(2)->create([
            'user_id' => $this->user->id,
        ]);
        $nonLoggedInUserIdeas = Idea::factory()->count(2)->create();

        $response = $this->actingAs($this->user)->get('/ideas');

        $response->assertStatus(200);
        $response->assertSee($loggedInUserIdeas->first()->title);
        $response->assertSee($loggedInUserIdeas->last()->title);
        $response->assertDontSee($nonLoggedInUserIdeas->first()->title);
        $response->assertDontSee($nonLoggedInUserIdeas->last()->title);
    }

    #[Test]
    public function show_displays_single_idea()
    {
        $idea = Idea::factory()->create();

        $response = $this->actingAs($this->user)->get("/ideas/{$idea->id}");

        $response->assertStatus(200);
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
    }

    #[Test]
    public function create_displays_form()
    {
        $response = $this->actingAs($this->user)->get('/ideas/create');

        $response->assertStatus(200);
        $response->assertViewIs('ideas.create');
        $response->assertSee('New Idea');
    }

    #[Test]
    public function store_creates_new_idea_with_valid_data()
    {
        $response = $this->actingAs($this->user)->post('/ideas', [
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
        $response = $this->actingAs($this->user)->post('/ideas', [
            'title' => 'No', // too short
            'description' => 'Short', // too short
            'status' => 'random',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'description', 'status']);
        $this->assertDatabaseCount('ideas', 0);
    }

    #[Test]
    public function store_fails_with_long_title_and_description()
    {
        $response = $this->actingAs($this->user)->post('/ideas', [
            'title' => Str::random(251), // too long
            'description' => Str::random(1501), // too long
            'status' => IdeaStatus::PENDING->value,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'description', 'status']);
        $this->assertDatabaseCount('ideas', 0);
    }

    #[Test]
    public function edit_displays_form()
    {
        $idea = Idea::factory()->create();

        $response = $this->actingAs($this->user)->get("/ideas/{$idea->id}/edit");

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

        $response = $this->actingAs($this->user)->patch("/ideas/{$idea->id}", [
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

        $response = $this->actingAs($this->user)->patch("/ideas/{$idea->id}", [
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
    public function update_fails_with_long_title_and_description_and_keeps_original_values()
    {
        $idea = Idea::factory()->create([
            'title' => 'Original Title',
            'description' => 'Original description that is long enough.',
            'status' => IdeaStatus::PENDING->value,
        ]);

        $response = $this->actingAs($this->user)->patch("/ideas/{$idea->id}", [
            'title' => Str::random(251), // too long
            'description' => Str::random(1501), // too long
            'status' => IdeaStatus::CANCELED->value,
        ]);

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors(['status']);
        $response->assertSessionHasErrors(['title', 'description']);
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

        $response = $this->actingAs($this->user)->delete("/ideas/{$idea->id}");

        $response->assertRedirect('/ideas');
        $this->assertDatabaseMissing('ideas', ['id' => $idea->id]);
    }

    #[Test]
    public function destroy_all_deletes_all_ideas()
    {
        Idea::factory()->count(10)->create();

        $response = $this->actingAs($this->user)->delete('/ideas');

        $response->assertRedirect('/ideas');
        $this->assertDatabaseCount('ideas', 0);
    }

    #[Test]
    public function guests_are_redirected_from_index()
    {
        $response = $this->get('/ideas');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function guests_cannot_view_single_idea()
    {
        $idea = Idea::factory()->create();

        $response = $this->get("/ideas/{$idea->id}");

        $response->assertRedirect('/login');
    }

    #[Test]
    public function guests_cannot_view_create_form()
    {
        $response = $this->get('/ideas/create');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function guests_cannot_store_new_idea()
    {
        $response = $this->post('/ideas', [
            'title' => 'Guest Idea',
            'description' => 'This should not be created by a guest.',
            'status' => IdeaStatus::PENDING->value,
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseCount('ideas', 0);
    }

    #[Test]
    public function guests_cannot_view_edit_form()
    {
        $idea = Idea::factory()->create();

        $response = $this->get("/ideas/{$idea->id}/edit");

        $response->assertRedirect('/login');
    }

    #[Test]
    public function guests_cannot_update_idea()
    {
        $idea = Idea::factory()->create([
            'title' => 'Original Title',
            'description' => 'Original description that is long enough.',
            'status' => IdeaStatus::PENDING->value,
        ]);

        $response = $this->patch("/ideas/{$idea->id}", [
            'title' => 'Hacked Title',
            'description' => 'Hacked description.',
            'status' => IdeaStatus::COMPLETED->value,
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
            'title' => 'Original Title',
        ]);
    }

    #[Test]
    public function guests_cannot_delete_idea()
    {
        $idea = Idea::factory()->create();

        $response = $this->delete("/ideas/{$idea->id}");

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('ideas', ['id' => $idea->id]);
    }

    #[Test]
    public function guests_cannot_delete_all_ideas()
    {
        Idea::factory()->count(3)->create();

        $response = $this->delete('/ideas');

        $response->assertRedirect('/login');
        $this->assertDatabaseCount('ideas', 3);
    }
}

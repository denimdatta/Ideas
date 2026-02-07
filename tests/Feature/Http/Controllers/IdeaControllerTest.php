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

        // Owner should see the status badge on their own idea cards
        foreach ($loggedInUserIdeas as $idea) {
            $response->assertSee($idea->status->getDisplayName());
        }
    }

    #[Test]
    public function index_orders_ideas_by_latest_created_at()
    {
        $oldIdea = Idea::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Oldest Idea',
            'created_at' => now()->subDays(2),
        ]);
        $newIdea = Idea::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Newest Idea',
            'created_at' => now()->subDay(),
        ]);

        $response = $this->actingAs($this->user)->get('/ideas');

        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $newIdea->title,
            $oldIdea->title,
        ]);
    }

    #[Test]
    public function index_shows_empty_state_when_user_has_no_ideas()
    {
        $response = $this->actingAs($this->user)->get('/ideas');

        $response->assertStatus(200);
        $response->assertSee('No ideas yet.');
    }

    #[Test]
    public function show_displays_single_idea()
    {
        $idea = Idea::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->get("/ideas/{$idea->id}");

        $response->assertStatus(200);
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        // Show page always displays status regardless of policy
        $response->assertSee($idea->status->getDisplayName());
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
        $response->assertSessionHas('create_success');
        $response->assertSessionHas('idea_id');

        $ideaId = session('idea_id');

        $this->assertDatabaseHas('ideas', [
            'id' => $ideaId,
            'title' => 'New Idea Title',
            'description' => 'A sufficiently long description for the new idea.',
            'status' => IdeaStatus::PENDING->value,
        ]);
    }

    #[Test]
    public function store_ignores_user_id_from_request()
    {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($this->user)->post('/ideas', [
            'title' => 'Spoofed User Id',
            'description' => 'A sufficiently long description for spoofed user id.',
            'user_id' => $otherUser->id,
        ]);

        $response->assertRedirect('/ideas');
        $response->assertSessionHas('idea_id');

        $ideaId = session('idea_id');

        $this->assertDatabaseHas('ideas', [
            'id' => $ideaId,
            'user_id' => $this->user->id,
        ]);
        $this->assertDatabaseMissing('ideas', [
            'id' => $ideaId,
            'user_id' => $otherUser->id,
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
    public function store_prohibits_status_in_request()
    {
        $response = $this->actingAs($this->user)->post('/ideas', [
            'title' => 'Title With Provided Status',
            'description' => 'A long enough description.',
            'status' => IdeaStatus::COMPLETED->value, // provided, but controller should ignore
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status']);
        $this->assertDatabaseCount('ideas', 0);
    }

    #[Test]
    public function edit_displays_form()
    {
        $idea = Idea::factory()->create([
            'user_id' => $this->user->id,
        ]);

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
        $idea = Idea::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->patch("/ideas/{$idea->id}", [
            'title' => 'Updated Title',
            'description' => 'An updated description that is long enough.',
            'status' => IdeaStatus::COMPLETED->value,
        ]);

        $response->assertRedirect("/ideas/{$idea->id}");
        $response->assertSessionHas('edit_success');
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
        $idea = Idea::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->delete("/ideas/{$idea->id}");

        $response->assertRedirect('/ideas');
        $response->assertSessionHas('delete_success');
        $this->assertDatabaseMissing('ideas', ['id' => $idea->id]);
    }

    #[Test]
    public function destroy_all_deletes_all_ideas()
    {
        $userIdeas = Idea::factory()->count(3)->create([
            'user_id' => $this->user->id,
        ]);
        $otherIdeas = Idea::factory()->count(5)->create();

        $response = $this->actingAs($this->user)->delete('/ideas');

        $response->assertRedirect('/ideas');
        $response->assertSessionHas('purge_success');

        // user's ideas must be deleted
        foreach ($userIdeas as $idea) {
            $this->assertDatabaseMissing('ideas', ['id' => $idea->id]);
        }

        // other users' ideas must remain
        $this->assertDatabaseCount('ideas', $otherIdeas->count());
        $this->assertDatabaseHas('ideas', ['id' => $otherIdeas->first()->id]);
    }

    #[Test]
    public function others_displays_only_others_ideas()
    {
        $otherUser = User::factory()->create();
        $otherIdeas = Idea::factory()->count(2)->create([
            'user_id' => $otherUser->id,
        ]);
        $ownIdeas = Idea::factory()->count(1)->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->get('/ideas/others');

        $response->assertStatus(200);

        // other users' ideas should be visible with links to their show pages
        foreach ($otherIdeas as $idea) {
            $response->assertSee($idea->title);
            $response->assertSee('/ideas/' . $idea->id);

            // Status badge should NOT be present on other users' idea cards (access denied)
            $response->assertDontSee($idea->status->getDisplayName());

            // But the view link (/ideas/{id}) should still be present
            $response->assertSee('/ideas/' . $idea->id);
        }

        // own ideas should not appear on the "others" page
        $response->assertDontSee($ownIdeas->first()->title);
    }

    #[Test]
    public function others_shows_empty_state_when_no_other_ideas_exist()
    {
        Idea::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->get('/ideas/others');

        $response->assertStatus(200);
        $response->assertSee('No ideas from Others.');
    }

    #[Test]
    public function guests_are_redirected_from_others()
    {
        $response = $this->get('/ideas/others');

        $response->assertRedirect('/login');
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

    // Authorization tests: ensure users cannot access/modify others' ideas
    #[Test]
    public function users_can_view_another_users_idea()
    {
        $otherUser = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)->get("/ideas/{$idea->id}");

        $response->assertStatus(200);
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        // Status badge should NOT be present on other users' idea cards (access denied)
        $response->assertDontSee($idea->status->getDisplayName());
    }

    #[Test]
    public function users_cannot_view_edit_form_for_another_users_idea()
    {
        $otherUser = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)->get("/ideas/{$idea->id}/edit");

        $response->assertStatus(403);
    }

    #[Test]
    public function users_cannot_update_another_users_idea()
    {
        $otherUser = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $otherUser->id,
            'title' => 'Original Title',
            'description' => 'Original description that is long enough.',
            'status' => IdeaStatus::PENDING->value,
        ]);

        $response = $this->actingAs($this->user)->patch("/ideas/{$idea->id}", [
            'title' => 'Hacked Title',
            'description' => 'Hacked description to replace original.',
            'status' => IdeaStatus::COMPLETED->value,
        ]);

        $response->assertStatus(403);

        // Ensure nothing changed
        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
            'title' => 'Original Title',
            'description' => 'Original description that is long enough.',
            'status' => IdeaStatus::PENDING->value,
        ]);
    }

    #[Test]
    public function users_cannot_delete_another_users_idea()
    {
        $otherUser = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)->delete("/ideas/{$idea->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('ideas', ['id' => $idea->id]);
    }
}

<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function create_displays_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    #[Test]
    public function store_logs_in_and_redirects_with_valid_credentials()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('Password123!'),
        ]);

        $response = $this->post('/login', [
            'username' => 'testuser',
            'password' => 'Password123!',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
        $this->assertNull($user->fresh()->remember_token);
    }

    #[Test]
    public function store_sets_remember_token_when_requested()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('Password123!'),
        ]);

        $response = $this->post('/login', [
            'username' => 'testuser',
            'password' => 'Password123!',
            'remember' => true,
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->fresh()->remember_token);
    }

    #[Test]
    public function store_fails_with_invalid_remember_value()
    {
        User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('Password123!'),
        ]);

        $response = $this->post('/login', [
            'username' => 'testuser',
            'password' => 'Password123!',
            'remember' => ['invalid'],
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['remember']);
        $this->assertGuest();
    }

    #[Test]
    public function store_fails_with_invalid_credentials()
    {
        User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('Password123!'),
        ]);

        $response = $this->post('/login', [
            'username' => 'testuser',
            'password' => 'WrongPassword123!',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['login_error']);
        $this->assertGuest();
    }

    #[Test]
    public function store_fails_with_invalid_data()
    {
        $response = $this->post('/login', [
            'username' => 'abc',
            'password' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['username', 'password']);
        $this->assertGuest();
    }

    #[Test]
    public function destroy_logs_out_and_redirects()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete('/logout');

        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }
}

<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function create_displays_form()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    #[Test]
    public function store_redirects_with_valid_data()
    {
        $response = $this->post('/register', [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'email_confirmation' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'first_name' => 'Test',
            'last_name' => 'User',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Your account has been created!');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'first_name' => 'Test',
            'last_name' => 'User',
        ]);

        $user = User::where('email', 'test@example.com')->first();
        $this->assertTrue(Hash::check('Password123!', $user->password));
    }

    #[Test]
    public function store_fails_with_invalid_data()
    {
        $response = $this->post('/register', [
            'username' => 'abc',
            'email' => 'not-an-email',
            'email_confirmation' => 'mismatch@example.com',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
            'first_name' => '',
            'last_name' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'username',
            'email',
            'password',
            'first_name',
            'last_name',
        ]);
        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    #[Test]
    public function store_fails_when_username_or_email_is_not_unique()
    {
        User::factory()->create([
            'username' => 'existinguser',
            'email' => 'existing@example.com',
        ]);

        $response = $this->post('/register', [
            'username' => 'existinguser',
            'email' => 'existing@example.com',
            'email_confirmation' => 'existing@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'first_name' => 'Test',
            'last_name' => 'User',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['username', 'email']);
        $this->assertGuest();
        $this->assertDatabaseCount('users', 1);
    }
}

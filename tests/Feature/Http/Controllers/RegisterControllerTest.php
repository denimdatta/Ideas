<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $response->assertSessionHas('success', 'Your account has been validated (NOT CREATED YET)!');
        $this->assertDatabaseCount('users', 0);
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
        $this->assertDatabaseCount('users', 0);
    }
}

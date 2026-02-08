<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PasswordResetControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_request_shows_forgot_password_view(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertOk();
        $response->assertViewIs('auth.forgot-password');
        $response->assertSee('Forgot Password');
    }

    #[Test]
    public function test_email_sends_reset_link_to_valid_user(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertSessionHas('status');
        Notification::assertSentTo($user, ResetPassword::class);
    }

    #[Test]
    public function test_email_requires_valid_email(): void
    {
        Notification::fake();

        $response = $this->from(route('password.request'))->post(route('password.email'), [
            'email' => 'not-an-email',
        ]);

        $response->assertRedirect(route('password.request'));
        $response->assertSessionHasErrors('email');
        Notification::assertNothingSent();
    }

    #[Test]
    public function test_email_returns_error_for_unknown_user(): void
    {
        Notification::fake();

        $response = $this->from(route('password.request'))->post(route('password.email'), [
            'email' => 'missing@example.com',
        ]);

        $response->assertRedirect(route('password.request'));
        $response->assertSessionHasErrors('email');
        Notification::assertNothingSent();
    }

    #[Test]
    public function test_reset_form_shows_reset_password_view_with_token(): void
    {
        $response = $this->get(route('password.reset', ['token' => 'test-token']));

        $response->assertOk();
        $response->assertViewIs('auth.reset-password');
        $response->assertViewHas('token', 'test-token');
    }

    #[Test]
    public function test_update_redirects_back_on_invalid_token(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->from(route('password.reset', ['token' => 'bad-token']))->post(route('password.update'), [
            'token' => 'bad-token',
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect(route('password.reset', ['token' => 'bad-token']));
        $response->assertSessionHasErrors('email');
    }

    #[Test]
    public function test_update_requires_confirmed_password(): void
    {
        $response = $this->from(route('password.reset', ['token' => 'test-token']))->post(route('password.update'), [
            'token' => 'test-token',
            'email' => 'user@example.com',
            'password' => 'new-password',
            'password_confirmation' => 'other-password',
        ]);

        $response->assertRedirect(route('password.reset', ['token' => 'test-token']));
        $response->assertSessionHasErrors('password');
    }

    #[Test]
    public function test_update_requires_token(): void
    {
        $response = $this->from(route('password.reset', ['token' => 'test-token']))->post(route('password.update'), [
            'email' => 'user@example.com',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect(route('password.reset', ['token' => 'test-token']));
        $response->assertSessionHasErrors('token');
    }

    #[Test]
    public function test_update_resets_password_with_valid_token(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $token = Password::createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect(route('login'));

        $user->refresh();
        $this->assertTrue(Hash::check('new-password', $user->password));
    }
}

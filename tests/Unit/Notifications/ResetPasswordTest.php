<?php

namespace Tests\Unit\Notifications;

use App\Models\User;
use App\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Default mail message of ResetPassword notification.
     *
     * Steps:
     *  1. Create a user.
     *  2. Create a ResetPassword notification instance with a token.
     *  3. Generate the mail message.
     *  4. Assert the mail message contains the correct subject, intro lines, action text, and action URL.
     */
    public function test_reset_password_notification_default_mail_message()
    {
        Notification::fake();

        $user = User::factory()->create();
        $token = 'test-token';
        $notification = new ResetPassword($token);

        $mailMessage = $notification->toMail($user);

        $expectedUrl = URL::route('password.reset', [
            'token' => $token,
            'email' => $user->getEmailForPasswordReset(),
        ]);

        $this->assertInstanceOf(MailMessage::class, $mailMessage);
        $this->assertEquals(Lang::get('Reset Password Notification'), $mailMessage->subject);
        $this->assertStringContainsString(Lang::get('You are receiving this email because we received a password reset request for your account.'), $mailMessage->introLines[0]);
        $this->assertStringContainsString(Lang::get('Reset Password'), $mailMessage->actionText);
        $this->assertEquals($expectedUrl, $mailMessage->actionUrl);
    }

    /**
     * Test: Reset password notification with custom reset URL callback.
     *
     * Steps:
     *  1. Set a custom URL callback for the ResetPassword notification.
     *  2. Create a user.
     *  3. Create a ResetPassword notification instance with a token.
     *  4. Generate the mail message.
     *  5. Assert the mail message action URL matches the custom URL.
     */
    public function test_reset_password_notification_custom_reset_url_callback()
    {
        Notification::fake();

        ResetPassword::createUrlUsing(function ($user, $token) {
            return 'http://example.com/custom-reset-url?token='.$token;
        });

        $user = User::factory()->create();
        $token = 'test-token';
        $notification = new ResetPassword($token);

        $mailMessage = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $mailMessage);
        $this->assertEquals('http://example.com/custom-reset-url?token='.$token, $mailMessage->actionUrl);
    }

    /**
     * Test: Reset password notification with custom mail message callback.
     *
     * Steps:
     *  1. Set a custom mail message callback for the ResetPassword notification.
     *  2. Create a user.
     *  3. Create a ResetPassword notification instance with a token.
     *  4. Generate the mail message.
     *  5. Assert the mail message contains the correct subject, intro lines, action text, and action URL.
     */
    public function test_reset_password_notification_custom_mail_message_callback()
    {
        Notification::fake();

        ResetPassword::toMailUsing(function ($user, $token) {
            return (new MailMessage)
                ->subject('Custom Subject')
                ->line('Custom intro line.')
                ->action('Custom Action Text', 'http://example.com/custom-reset-url?token='.$token);
        });

        $user = User::factory()->create();
        $token = 'test-token';
        $notification = new ResetPassword($token);

        $mailMessage = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $mailMessage);
        $this->assertEquals('Custom Subject', $mailMessage->subject);
        $this->assertStringContainsString('Custom intro line.', $mailMessage->introLines[0]);
        $this->assertStringContainsString('Custom Action Text', $mailMessage->actionText);
        $this->assertEquals('http://example.com/custom-reset-url?token='.$token, $mailMessage->actionUrl);
    }

    /**
     * Test: Reset password attempt with invalid data displays error message.
     *
     * Steps:
     *  1. Initialize Livewire test for 'auth.reset-password' component with invalid token.
     *  2. Set email, password, and password confirmation.
     *  3. Call 'resetPassword' method.
     *  4. Assert that an error message is displayed.
     */
    public function test_password_reset_attempt_with_invalid_data_displays_error_message(): void
    {
        Livewire::test('auth.reset-password', ['token' => 'test_token'])
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('resetPassword');

        // Retrieve the session data
        $sessionData = session()->all();

        // Assert that the session contains the correct key
        $this->assertArrayHasKey('type', $sessionData['mary']['toast']);

        // Correct way to access session data
        $this->assertEquals('error', $sessionData['mary']['toast']['type']);
    }

    /**
     * Test: Password reset attempt when throttled displays error message.
     *
     * Steps:
     *  1. Mock the Password facade to return a reset throttled status.
     *  2. Initialize Livewire test for 'auth.reset-password' component with the throttled token.
     *  3. Set email, password, and password confirmation.
     *  4. Call 'resetPassword' method.
     *  5. Assert that an error message is displayed.
     */
    public function test_password_reset_attempt_when_throttled_displays_error_message(): void
    {
        $throttledToken = 'throttled_token';

        Password::shouldReceive('reset')->andReturn(Password::RESET_THROTTLED);

        Livewire::test('auth.reset-password', ['token' => $throttledToken])
            ->set('email', 'test@example.com')
            ->set('password', 'newpassword')
            ->set('password_confirmation', 'newpassword')
            ->call('resetPassword');

        // Retrieve the session data
        $sessionData = session()->all();

        // Assert that the session contains the correct key
        $this->assertArrayHasKey('type', $sessionData['mary']['toast']);

        // Correct way to access session data
        $this->assertEquals('error', $sessionData['mary']['toast']['type']);
    }

    /**
     * Test: Password reset attempt with generic error displays error message.
     *
     * Steps:
     *  1. Mock the Password facade to return a generic error status.
     *  2. Initialize Livewire test for 'auth.reset-password' component.
     *  3. Set email, password, and password confirmation.
     *  4. Call 'resetPassword' method.
     *  5. Assert that an error message is displayed.
     */
    public function test_password_reset_attempt_with_generic_error_displays_error_message(): void
    {
        Password::shouldReceive('reset')->andReturn('unexpected_error_code');

        Livewire::test('auth.reset-password', ['token' => 'valid_token'])
            ->set('email', 'test@example.com')
            ->set('password', 'newpassword')
            ->set('password_confirmation', 'newpassword')
            ->call('resetPassword');

        // Retrieve the session data
        $sessionData = session()->all();

        // Assert that the session contains the correct key
        $this->assertArrayHasKey('type', $sessionData['mary']['toast']);

        // Correct way to access session data
        $this->assertEquals('error', $sessionData['mary']['toast']['type']);
    }

    /**
     * Test: Flash message for invalid user status is added.
     *
     * Steps:
     *  1. Mock the Password facade to return an invalid user status.
     *  2. Initialize Livewire test for 'auth.reset-password' component.
     *  3. Set email, password, and password confirmation.
     *  4. Call 'resetPassword' method.
     *  5. Assert that the flash message for invalid status is set correctly.
     */
    public function test_flash_message_for_invalid_user_status_is_added()
    {
        Password::shouldReceive('reset')->andReturn(Password::INVALID_USER);

        Livewire::test('auth.reset-password', ['token' => 'valid_token'])
            ->set('email', 'test@example.com')
            ->set('password', 'newpassword')
            ->set('password_confirmation', 'newpassword')
            ->call('resetPassword')
            ->assertRedirect(route('login'))
            ->assertHasNoErrors();

        // Retrieve the session data
        $sessionData = session()->all();

        // Assert that the session contains the correct key
        $this->assertArrayHasKey('type', $sessionData['mary']['toast']);

        // Correct way to access session data
        $this->assertEquals('error', $sessionData['mary']['toast']['type']);
    }
}

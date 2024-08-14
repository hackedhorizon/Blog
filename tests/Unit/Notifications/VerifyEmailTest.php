<?php

namespace Tests\Unit\Notifications;

use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the notification sends an email with the correct content.
     *
     * @return void
     */
    public function test_notification_contains_correct_content()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // Mock the URL generation
        $mockUrl = 'http://example.com/verify-email/1/hash';
        URL::shouldReceive('temporarySignedRoute')
            ->once()
            ->andReturn($mockUrl);

        // Capture the notification
        NotificationFacade::fake();
        $user->notify(new VerifyEmail());

        // Assert the notification was sent
        NotificationFacade::assertSentTo(
            $user,
            VerifyEmail::class,
            function (VerifyEmail $notification) use ($mockUrl, $user) {
                $mailMessage = $notification->toMail($user);

                return $mailMessage->actionUrl === $mockUrl;
            }
        );
    }

    /**
     * Test the notification URL callback.
     *
     * @return void
     */
    public function test_notification_url_callback()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // Set a custom URL callback
        VerifyEmail::createUrlUsing(function ($notifiable) {
            return 'http://example.com/custom-url';
        });

        // Capture the notification
        NotificationFacade::fake();

        // Trigger the notification
        $user->notify(new VerifyEmail());

        // Assert the notification was sent
        NotificationFacade::assertSentTo(
            $user,
            VerifyEmail::class,
            function (VerifyEmail $notification) use ($user) {
                $mailMessage = $notification->toMail($user);

                return $mailMessage->actionUrl === 'http://example.com/custom-url';
            }
        );
    }

    /**
     * Test the notification mail callback.
     *
     * @return void
     */
    public function test_notification_mail_callback()
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Custom Subject')
                ->line('Custom line')
                ->action('Custom Action', $url);
        });

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        NotificationFacade::fake();

        // Trigger the notification
        $user->notify(new VerifyEmail());

        // Assert the notification was sent
        NotificationFacade::assertSentTo(
            $user,
            VerifyEmail::class,
            function (VerifyEmail $notification) use ($user) {
                $mailMessage = $notification->toMail($user);

                // Assert the subject
                $this->assertEquals('Custom Subject', $mailMessage->subject);

                // Assert the action text
                $this->assertEquals('Custom Action', $mailMessage->actionText);

                // Assert the lines in the email message
                $lines = $mailMessage->introLines; // Check if introLines is populated
                $this->assertContains('Custom line', $lines);

                return true; // or return any other condition as needed
            }
        );
    }
}

<?php

namespace Tests\Feature\Notifications;

use App\Models\User;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResetPasswordNotificationTest extends TestCase
{
    public function test_notification_is_sent_to_user()
    {
        // Arrange
        $user = User::factory()->create();
        $token = 'sample-token';

        // Mock the notification facade
        Notification::fake();

        // Act
        $user->notify(new ResetPassword($token));

        // Assert
        Notification::assertSentTo(
            [$user],
            ResetPassword::class,
            function ($notification) use ($token) {
                return $notification->token === $token;
            }
        );
    }
}

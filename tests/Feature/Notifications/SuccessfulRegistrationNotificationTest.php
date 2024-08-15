<?php

namespace Tests\Feature\Notifications;

use App\Models\User;
use App\Notifications\SuccessfulRegistrationNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SuccessfulRegistrationNotificationTest extends TestCase
{
    public function test_notification_is_sent_to_user()
    {
        // Arrange: Create a user and mock the notification
        $user = User::factory()->create();

        // Mock the notification facade
        Notification::fake();

        // Act: Trigger the notification
        $user->notify(new SuccessfulRegistrationNotification);

        // Assert: Verify that the notification was sent
        Notification::assertSentTo(
            [$user],
            SuccessfulRegistrationNotification::class,
            function ($notification) use ($user) {
                // Assert the notification has the correct data
                $data = $notification->toDatabase($user);

                return $data['title'] === __('notifications.registration.welcome') &&
                       $data['message'] === __('notifications.registration.success', ['username' => $user->name]);
            }
        );
    }

    public function test_notification_data_contains_correct_values()
    {
        // Arrange: Create a user
        $user = User::factory()->create();

        // Act: Create the notification instance
        $notification = new SuccessfulRegistrationNotification;
        $data = $notification->toDatabase($user);

        // Assert: Verify the data structure
        $this->assertArrayHasKey('title', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals(__('notifications.registration.welcome'), $data['title']);
        $this->assertEquals(__('notifications.registration.success', ['username' => $user->name]), $data['message']);
    }
}

<?php

namespace Tests\Feature\Livewire\Features;

use App\Models\User;
use App\Notifications\SuccessfulRegistrationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_notifications()
    {
        // Arrange
        $user = User::factory()->create();
        $user->notify(new SuccessfulRegistrationNotification);

        // Act & Assert
        Livewire::actingAs($user)
            ->test('features.notification')
            ->assertSee(__('notifications.registration.welcome'))
            ->assertSee(__('notifications.registration.success', ['username' => $user->name]));
    }

    /** @test */
    public function it_shows_unread_notifications_count()
    {
        // Arrange
        $user = User::factory()->create();
        $user->notify(new SuccessfulRegistrationNotification);

        // Act & Assert
        Livewire::actingAs($user)
            ->test('features.notification')
            ->assertSee('1'); // Ensure that the unread notifications count is correct
    }

    /** @test */
    public function it_marks_notification_as_read()
    {
        // Arrange
        $user = User::factory()->create();
        $user->notify(new SuccessfulRegistrationNotification);

        // Fetch the notification to get the ID
        $notification = $user->notifications()->first();
        $notificationId = $notification->id;

        // Act
        Livewire::actingAs($user)
            ->test('features.notification')
            ->call('markAsRead', $notificationId);

        // Assert
        $notification->refresh();
        $this->assertNotNull($notification->read_at);
    }

    /** @test */
    public function it_deletes_notification()
    {
        // Arrange
        $user = User::factory()->create();
        $user->notify(new SuccessfulRegistrationNotification);

        // Fetch the notification to get the ID
        $notification = $user->notifications()->first();
        $notificationId = $notification->id;

        // Act
        Livewire::actingAs($user)
            ->test('features.notification')
            ->call('deleteNotification', $notificationId);

        // Assert
        $this->assertDatabaseMissing('notifications', ['id' => $notificationId]);
    }

    /** @test */
    public function it_displays_no_notifications_message_when_empty()
    {
        // Arrange
        $user = User::factory()->create();

        // Act & Assert
        Livewire::actingAs($user)
            ->test('features.notification')
            ->assertSee(__('notifications.info.no_notifications_available'));
    }
}

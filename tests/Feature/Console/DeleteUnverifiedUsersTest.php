<?php

namespace Tests\Feature\Console;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class DeleteUnverifiedUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Delete unverified users older than expiration date.
     *
     * Steps:
     *  1. Create an unverified user older than the expiration date.
     *  2. Run the command to delete unverified users.
     *  3. Assert that the user has been deleted from the database.
     */
    public function test_unverified_users_deleted()
    {
        // Create an unverified user older than the expiration date
        $unverifiedUser = User::factory()->create([
            'email_verified_at' => null,
            'created_at' => now()->subDays(config('auth.verification.expire', 7) + 1),
        ]);

        // Run the command
        Artisan::call('app:delete-unverified-users');

        // Assert the user has been deleted
        $this->assertDatabaseMissing('users', ['id' => $unverifiedUser->id]);
    }

    /**
     * Test: Command does not run when email verification is disabled.
     *
     * Steps:
     *  1. Disable email verification.
     *  2. Create an unverified user.
     *  3. Run the command to delete unverified users.
     *  4. Assert that the user still exists.
     */
    public function test_command_does_not_run_without_email_verification()
    {
        // Temporarily override configuration to simulate email verification disabled
        config(['services.should_verify_email' => false]);

        // Create an unverified user
        $user = User::factory()->create(['email_verified_at' => null]);

        // Run the command
        Artisan::call('app:delete-unverified-users');

        // Assert the user still exists
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /**
     * Test: Force deletion of all unverified users.
     *
     * Steps:
     *  1. Create unverified users, some older than the expiration date and some newer.
     *  2. Run the command with the --force option.
     *  3. Assert that all unverified users are deleted.
     */
    public function test_force_deletes_all_unverified_users()
    {
        // Create unverified users
        $oldUnverifiedUser = User::factory()->create([
            'email_verified_at' => null,
            'created_at' => now()->subDays(config('auth.verification.expire', 7) + 1),
        ]);
        $recentUnverifiedUser = User::factory()->create([
            'email_verified_at' => null,
            'created_at' => now(),
        ]);

        // Run the command with --force
        Artisan::call('app:delete-unverified-users --force');

        // Assert that all unverified users are deleted
        $this->assertDatabaseMissing('users', ['id' => $oldUnverifiedUser->id]);
        $this->assertDatabaseMissing('users', ['id' => $recentUnverifiedUser->id]);
    }

    /**
     * Test: No unverified users to delete.
     *
     * Steps:
     *  1. Ensure there are no unverified users older than the expiration date.
     *  2. Run the command.
     *  3. Assert that no users are deleted.
     */
    public function test_no_unverified_users_to_delete()
    {
        // Create a verified user
        User::factory()->create(['email_verified_at' => now()]);

        // Run the command
        Artisan::call('app:delete-unverified-users');

        // Assert that no users are deleted
        $this->assertDatabaseCount('users', 1);
    }
}

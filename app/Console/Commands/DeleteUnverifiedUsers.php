<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteUnverifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-unverified-users {--force : Force delete all unverified users}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unverified users who haven\'t verified their email within the specified timeframe';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $forceDelete = $this->option('force');
        $expirationDate = now()->subDays(config('auth.verification.expire', 7));

        if ($forceDelete) {
            $this->info('Forcing deletion of all unverified users...');
            $unverifiedUsers = User::whereNull('email_verified_at')->get();
        } else {
            $this->info('Deleting unverified users who have not verified their email within the last '.config('auth.verification.expire', 7).' days...');
            $unverifiedUsers = User::whereNull('email_verified_at')
                ->where('created_at', '<=', $expirationDate)
                ->get();
        }

        if ($unverifiedUsers->isEmpty()) {
            $this->info('No unverified users found for deletion.');

            return;
        }

        $this->info('Found '.$unverifiedUsers->count().' unverified users.');

        foreach ($unverifiedUsers as $user) {
            $this->info('Deleting user: ID: '.$user->id.', Created At: '.$user->created_at);
            $user->delete();
        }

        $this->info(count($unverifiedUsers).' unverified users deleted successfully.');
        $this->info('Command execution finished.');
    }
}

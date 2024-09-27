<?php

namespace App\Console\Commands;

use App\Jobs\PublishPostJob;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish-scheduled';

    protected $description = 'Publish scheduled posts that are due for publication';

    public function handle()
    {
        Log::info('Running posts:publish-scheduled command');

        Post::where('published_at', '<=', now())->where('is_published', false)->each(function ($post) {
            Log::info('Dispatching PublishPostJob for post ID: '.$post->id);

            PublishPostJob::dispatch($post->id, $post->user_id)->onQueue('database.notifications');
        });

        $this->info('Scheduled posts have been dispatched for publishing.');
    }
}

<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostPublishedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PublishPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $postId;

    protected int $userId;

    public function __construct(int $postId, int $userId)
    {
        $this->postId = $postId;
        $this->userId = $userId;
    }

    public function handle()
    {
        Log::info('Starting the job for the post ID: '.$this->postId);

        // Use a transaction to ensure atomicity
        DB::transaction(function () {
            $post = Post::find($this->postId);
            $user = User::find($this->userId);

            if ($post && $user && $post->published_at <= now() && ! $post->is_published) {
                // Update post to be published
                $post->update(['is_published' => true]);

                // Log the publishing event
                Log::info("Post published: {$post->title} (ID: {$post->id})");

                // Notify the user via database notification
                $user->notify(new PostPublishedNotification($post->title));
            } else {
                Log::warning('Post or User not found, or post already published.');
            }
        });
    }
}

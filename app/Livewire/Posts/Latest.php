<?php

namespace App\Livewire\Posts;

use App\Modules\Post\Interfaces\ReadPostServiceInterface;
use App\Modules\Post\Services\ReadPostService;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Latest extends Component
{
    private ReadPostServiceInterface $readPostService;

    public function render()
    {
        return view('livewire.posts.latest');
    }

    public function boot(ReadPostService $readPostService)
    {
        $this->readPostService = $readPostService;
    }

    public function placeholder()
    {
        return view('livewire.placeholders.article-skeleton', ['param' => 'Latest']);
    }

    #[Computed()]
    public function posts()
    {
        return $this->readPostService->getLatestPosts(3);
    }
}

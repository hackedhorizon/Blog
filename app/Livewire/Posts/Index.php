<?php

namespace App\Livewire\Posts;

use App\Modules\Post\Interfaces\ReadPostServiceInterface;
use App\Modules\Post\Services\ReadPostService;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    private ReadPostServiceInterface $postService;

    public function render()
    {
        return view('livewire.posts.index');
    }

    public function boot(ReadPostService $postService)
    {
        $this->postService = $postService;
    }

    public function paginationView()
    {
        return 'components.pagination.links';
    }

    public function placeholder()
    {
        return view('livewire.placeholders.article-skeleton', ['param' => 'Articles']);
    }

    #[Computed()]
    public function posts()
    {
        $posts = $this->postService->getPaginatedPosts(3, 'article-page');

        return $posts;
    }
}

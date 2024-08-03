<?php

namespace App\Livewire\Posts;

use App\Modules\Post\Interfaces\ReadPostServiceInterface;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Featured extends Component
{
    use WithPagination;

    private ReadPostServiceInterface $postService;

    public function render()
    {
        return view('livewire.posts.featured');
    }

    public function boot(ReadPostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    public function paginationView()
    {
        return 'components.pagination.links';
    }

    public function placeholder()
    {
        return view('livewire.placeholders.article-skeleton', ['param' => 'Featured']);
    }

    #[Computed()]
    public function posts()
    {
        return $this->postService->getFeaturedPaginatedPosts(3, pageName: 'featured-post');
    }
}

<?php

namespace App\Livewire\Posts;

use App\Modules\Post\Services\ReadPostService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public string $author;

    public string $date;

    public string $title;

    public string $body;

    public string $tags;

    private string $pageTitle = '';

    protected ReadPostService $readPostService;

    public function mount(int $id, ReadPostService $readPostService)
    {
        $this->pageTitle = __('Articles');

        $this->readPostService = $readPostService;

        $postDTO = $this->readPostService->getPostDetails($id);

        if (! $postDTO->getPostIsPublished() && ! Auth::user()->can('view unpublished posts')) {
            abort(403, 'Post not found or not accessible.');
        }

        $this->author = $postDTO->getAuthor();
        $this->date = $postDTO->getCreationDate();
        $this->title = $postDTO->getTitle();
        $this->body = $postDTO->getBody();
        $this->tags = $postDTO->getCategories();
    }

    public function render()
    {
        return view('livewire.posts.show')->title($this->pageTitle);
    }
}

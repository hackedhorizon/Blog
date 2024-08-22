<?php

namespace App\Livewire\Posts;

use App\Modules\Post\Interfaces\ReadPostServiceInterface;
use App\Modules\Post\Services\ReadPostService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    private ReadPostServiceInterface $readPostService;

    #[Url(as: 'q', history: true, keep: true)]
    public $search = '';

    public function render()
    {
        return view('livewire.posts.index');
    }

    public function mount()
    {
        $this->search = '';
    }

    public function boot(ReadPostService $readPostService)
    {
        $this->readPostService = $readPostService;
    }

    public function paginationView()
    {
        return 'components.pagination.links';
    }

    public function placeholder()
    {
        return view('livewire.placeholders.article-skeleton', ['param' => 'Articles']);
    }

    public function updatedSearch()
    {
        $this->resetPage('article-page');
    }

    #[Computed]
    public function posts()
    {
        $shouldHaveLocalization = config('services.should_have_localization');

        return $this->readPostService->searchPosts($this->search, $shouldHaveLocalization, 3);
    }
}

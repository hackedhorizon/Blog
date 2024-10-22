<?php

namespace App\Livewire\AdminPanel\Posts;

use App\Modules\Post\Interfaces\ReadPostServiceInterface;
use App\Modules\Post\Interfaces\WritePostServiceInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Lazy]
class Index extends Component
{
    use Toast;
    use WithPagination;

    public $perPage = 10;

    #[Url(as: 'q', history: true, keep: true)]
    public $search = '';

    public array $sortBy = [];

    public array $selected = [];

    public $perPageOptions = [];

    protected $listeners = ['postDeleted' => '$refresh', 'post-updated' => '$refresh'];

    private WritePostServiceInterface $writePostService;

    private ReadPostServiceInterface $readPostService;

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin-panel.posts.index');
    }

    public function boot(WritePostServiceInterface $writePostService, ReadPostServiceInterface $readPostService)
    {
        $this->writePostService = $writePostService;
        $this->readPostService = $readPostService;
    }

    public function mount()
    {
        if (! auth()->user() || ! auth()->user()->can('view unpublished posts') || ! auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $this->search = '';

        $this->perPageOptions = [
            ['name' => __('pagination.per_page.10'), 'value' => 10],
            ['name' => __('pagination.per_page.25'), 'value' => 25],
            ['name' => __('pagination.per_page.50'), 'value' => 50],
            ['name' => __('pagination.per_page.100'), 'value' => 100],
        ];

        $this->sortBy = ['column' => 'created_at', 'direction' => 'desc'];
    }

    public function paginationView()
    {
        return 'components.pagination.links';
    }

    public function placeholder()
    {
        return view('livewire.placeholders.admin.edit-post-skeleton', ['param' => 'Latest']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[Computed()]
    public function posts()
    {
        return $this->readPostService->getPaginatedPosts($this->sortBy, $this->search, $this->perPage);
    }

    public function updateSelected($selectedIds)
    {
        $this->selected = $selectedIds;
    }

    public function delete($postId = null)
    {
        try {
            $this->writePostService->deletePost($postId, $this->selected);

            $this->selected = [];

            return $this->success(
                title: __('posts.'.($postId ? 'Post deleted successfully' : 'Selected posts deleted successfully')),
                icon: 'o-check-circle'
            );
        } catch (\Exception $e) {
            return $this->error(
                title: $e->getMessage(),
                icon: 'o-information-circle'
            );
        }
    }
}

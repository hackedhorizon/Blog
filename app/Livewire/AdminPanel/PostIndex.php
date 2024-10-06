<?php

namespace App\Livewire\AdminPanel;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class PostIndex extends Component
{
    use WithPagination;

    public $perPage = 10;

    #[Url(as: 'q', history: true, keep: true)]
    public $search = '';

    public array $sortBy = [];

    public array $selected = [];

    public $perPageOptions = [];

    protected $listeners = ['postDeleted' => '$refresh'];

    #[Layout('components.layouts.admin')]
    public function render()
    {
        // Use withAggregate to add `user_username` to the result set
        $posts = Post::query()
            ->withAggregate('user', 'username') // This adds `user_username` as a column
            ->where('posts.title', 'like', "%{$this->search}%")
            ->orderBy($this->sortBy['column'], $this->sortBy['direction']) // Sorting by the aggregated column
            ->paginate($this->perPage);

        return view('livewire.admin-panel.post-index', ['posts' => $posts]);
    }

    public function paginationView()
    {
        return 'components.pagination.links';
    }

    public function mount()
    {
        $this->search = '';

        $this->perPageOptions = [
            ['name' => __('pagination.per_page.10'), 'value' => 10],
            ['name' => __('pagination.per_page.25'), 'value' => 25],
            ['name' => __('pagination.per_page.50'), 'value' => 50],
            ['name' => __('pagination.per_page.100'), 'value' => 100],
        ];

        $this->sortBy = ['column' => 'created_at', 'direction' => 'desc'];
    }

    public function placeholder()
    {
        return view('livewire.placeholders.admin.edit-post-skeleton', ['param' => 'Latest']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updateSelected($selectedIds)
    {
        $this->selected = $selectedIds; // Update the selected property
    }

    // public function deletePost($postId)
    // {
    //     Post::find($postId)->delete();
    //     $this->dispatchBrowserEvent('notification', ['type' => 'success', 'message' => 'Post deleted successfully']);
    //     $this->emit('postDeleted');
    // }
}

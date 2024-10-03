<?php

namespace App\Livewire\AdminPanel;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostIndex extends Component
{
    use WithPagination;

    public $perPage = 10;

    #[Url(as: 'q', history: true, keep: true)]
    public $search = '';

    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

    public array $selected = [];

    public $perPageOptions = [
        ['name' => '10 per page', 'value' => 10],
        ['name' => '25 per page', 'value' => 25],
        ['name' => '50 per page', 'value' => 50],
        ['name' => '100 per page', 'value' => 100],
    ];

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

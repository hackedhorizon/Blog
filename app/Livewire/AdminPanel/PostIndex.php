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

    public $perPage = 10; // Number of posts per page
    #[Url(as: 'q', history: true, keep: true)]
    public $search = ''; // For searching posts by title
    public $sortField = 'created_at'; // Default sorting field
    public $sortDirection = 'desc'; // Default sorting direction

    public $perPageOptions = [
        ['name' => '10 per page', 'value' => 10],
        ['name' => '25 per page', 'value' => 25],
        ['name' => '50 per page', 'value' => 50],
        ['name' => '100 per page', 'value' => 100],
    ];

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['postDeleted' => '$refresh'];

    #[Layout('components.layouts.admin')]
    public function render()
    {
        $posts = Post::query()
            ->where('title', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection)
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

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deletePost($postId)
    {
        Post::find($postId)->delete();
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'message' => 'Post deleted successfully']);
        $this->emit('postDeleted');
    }
}

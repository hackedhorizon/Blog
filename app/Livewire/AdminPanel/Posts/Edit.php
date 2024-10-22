<?php

namespace App\Livewire\AdminPanel\Posts;

use App\Modules\Categories\Interfaces\ReadCategoryServiceInterface;
use App\Modules\Post\DTOs\PostDTO;
use App\Modules\Post\Interfaces\ReadPostServiceInterface;
use App\Modules\Post\Interfaces\WritePostServiceInterface;
use Livewire\Attributes\Locked;
use LivewireUI\Modal\ModalComponent;
use Mary\Traits\Toast;

class Edit extends ModalComponent
{
    use Toast;

    #[Locked]
    public int $post; // Post ID (type hinted)

    public string $author;

    public string $title;

    public string $body;

    public bool $featured;

    public array $categories = [];       // All categories from the database

    public array $newCategories = [];    // Newly selected categories

    public $currentCategories = [];      // Currently associated categories

    private ReadPostServiceInterface $readPostService;

    private WritePostServiceInterface $writePostService;

    private ReadCategoryServiceInterface $readCategoryService;

    /**
     * Render the view associated with this component.
     */
    public function render()
    {
        return view('livewire.admin-panel.posts.edit');
    }

    /**
     * Boot method to inject dependencies and load post data.
     */
    public function boot(ReadPostServiceInterface $readPostService, WritePostServiceInterface $writePostService, ReadCategoryServiceInterface $readCategoryService)
    {
        $this->readPostService = $readPostService;
        $this->writePostService = $writePostService;
        $this->readCategoryService = $readCategoryService;
        $this->loadPost();
    }

    /**
     * Authorization check when mounting the component.
     */
    public function mount()
    {
        if (! auth()->user()->can('edit posts')) {
            abort(403, 'You do not have permission to edit posts.');
        }
    }

    /**
     * Load the post details and map them to the component properties.
     */
    private function loadPost()
    {
        $post = $this->readPostService->getPostDetails($this->post);
        $this->mapPostToComponent($post);
    }

    /**
     * Map the PostDTO data to the component properties.
     *
     * @param  PostDTO  $post  The data transfer object containing post information.
     */
    private function mapPostToComponent(PostDTO $post)
    {
        // Assign post properties to component state
        $this->author = $post->getAuthor();
        $this->title = $post->getTitle();
        $this->body = $post->getBody();
        $this->featured = $post->getPostIsFeatured();

        // Fetch all available categories and format them for the UI
        $this->categories = $this->readCategoryService->getCategories()
            ->map(fn ($category) => ['label' => $category['name'], 'value' => $category['id']])
            ->toArray();

        // Load the categories currently associated with the post
        $this->currentCategories = $post->getCategories();
    }

    /**
     * Validate and save the post updates.
     */
    public function save()
    {
        // Validate input fields
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'author' => 'required|string',
            'featured' => 'boolean',
        ]);

        // Data array for updating the post
        $data = [
            'title' => $validated['title'],
            'body' => $validated['body'],
            'is_featured' => $validated['featured'],
        ];

        // Save the post and update categories if applicable
        $this->writePostService->updatePost($this->post, $data, $this->newCategories);

        // Show a success message
        $this->success('Post updated successfully.');

        // Dispatch an event on update for the Index component to refresh posts
        $this->dispatch('post-updated')->to(Index::class);

        // Close the modal
        $this->close();
    }

    /**
     * Close the modal and clean up any TinyMCE instances.
     */
    public function close()
    {
        // Fire events to remove TinyMCE editor instances before closing
        $this->dispatch('removeTinyMCE');
        $this->dispatch('closeModal');
    }

    /**
     * Prevent closing the modal by clicking outside or pressing Escape
     * to ensure TinyMCE editor instance is properly handled.
     */
    public static function closeModalOnClickAway(): bool
    {
        return false;
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }
}

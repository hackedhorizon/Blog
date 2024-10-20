<?php

namespace App\Livewire\AdminPanel;

use App\Modules\Categories\Interfaces\ReadCategoryServiceInterface;
use App\Modules\Post\DTOs\PostCreateDTO;
use App\Modules\Post\Interfaces\WritePostServiceInterface;
use DateTime;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class PostCreate extends Component
{
    use Toast;

    #[Validate('required|string|min:5')]
    public string $title = '';

    #[Validate('required|string|min:3')]
    public string $content = '';

    #[Validate('required')]
    public array $selectedCategories = [];

    public string $detectedLanguage = '';

    public bool $featured = false;

    public bool $publishNow = true;

    public DateTime $publicationDate;

    public array $categories = [];

    private ReadCategoryServiceInterface $readCategoryService;

    private WritePostServiceInterface $writePostService;

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin-panel.post-create');
    }

    public function boot(ReadCategoryServiceInterface $readCategoryService, WritePostServiceInterface $writePostService)
    {
        if (! auth()->user() || ! auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $this->readCategoryService = $readCategoryService;
        $this->writePostService = $writePostService;
    }

    public function mount()
    {
        $this->detectedLanguage = session()->get('locale', 'en');
        $this->categories = $this->readCategoryService->getCategories()
            ->map(fn ($category) => ['label' => $category['name'], 'value' => $category['id']])
            ->toArray();
        $this->publicationDate = now();
    }

    public function createPost()
    {
        $this->validate();

        $postCreateDTO = new PostCreateDTO(
            $this->title,
            $this->content,
            $this->detectedLanguage,
            $this->publishNow,
            $this->featured,
            $this->publicationDate,
            $this->selectedCategories
        );

        try {
            $this->writePostService->createPost($postCreateDTO);
            $this->success(title: __('posts.Post created successfully'));
        } catch (\Exception $e) {
            $this->error(title: $e->getMessage());
        }
    }
}

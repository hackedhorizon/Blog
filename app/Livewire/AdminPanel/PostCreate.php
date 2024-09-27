<?php

namespace App\Livewire\AdminPanel;

use App\Modules\Categories\Services\ReadCategoryService;
use App\Modules\Localization\Interfaces\LocalizationServiceInterface;
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
    public bool $published = true;
    public bool $autoTranslate = true;
    public DateTime $publicationDate;
    public array $languages = [];
    public array $selectedLanguages = [];
    public array $categories = [];

    private LocalizationServiceInterface $localizationService;
    private ReadCategoryService $readCategoryService;
    private WritePostServiceInterface $writePostService;

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin-panel.post-create');
    }

    public function boot(LocalizationServiceInterface $localizationService, ReadCategoryService $readCategoryService, WritePostServiceInterface $writePostService)
    {
        $this->localizationService = $localizationService;
        $this->readCategoryService = $readCategoryService;
        $this->writePostService = $writePostService;
        $this->publicationDate = now();
    }

    public function mount()
    {
        $this->detectedLanguage = session()->get('locale');
        $this->languages = collect(config('app.locales'))->map(fn($label, $code) => ['value' => $code, 'label' => $label])->values()->toArray();
        $this->categories = $this->readCategoryService->getCategories()->map(fn($category) => ['label' => $category['name'], 'value' => $category['id']])->toArray();
    }

    public function createPost()
    {
        $this->validate();

        $postCreateDTO = new PostCreateDTO(
            $this->title,
            $this->content,
            $this->detectedLanguage,
            $this->published,
            $this->featured,
            $this->publicationDate,
            $this->selectedCategories,
            $this->autoTranslate,
            $this->selectedLanguages
        );

        $this->writePostService->createPost($postCreateDTO);
        $this->success(title: __('posts.Post created successfully'));
    }
}

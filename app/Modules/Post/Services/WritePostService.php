<?php

namespace App\Modules\Post\Services;

use App\Modules\Localization\Interfaces\LocalizationServiceInterface;
use App\Modules\Post\DTOs\PostCreateDTO;
use App\Modules\Post\Interfaces\WritePostRepositoryInterface;
use App\Modules\Post\Interfaces\WritePostServiceInterface;
use Illuminate\Support\Facades\Log;

class WritePostService implements WritePostServiceInterface
{
    protected WritePostRepositoryInterface $writePostRepository;

    protected LocalizationServiceInterface $localizationService;

    public function __construct(
        WritePostRepositoryInterface $writePostRepository,
        LocalizationServiceInterface $localizationService
    ) {
        $this->writePostRepository = $writePostRepository;
        $this->localizationService = $localizationService;
    }

    public function createPost(PostCreateDTO $postCreateDTO): void
    {
        // Detect the language of the post's title
        $detectedLanguage = strtolower($this->localizationService->detectLanguage($postCreateDTO->title));

        if (! $detectedLanguage) {
            throw new \Exception(__('posts.Language detection failed.'));
        }

        // Assign detected language to the DTO
        $postCreateDTO->detectedLanguage = $detectedLanguage;

        // Determine target languages for translation
        $locales = config('app.locales');
        $targetLanguages = $postCreateDTO->autoTranslate
            ? array_diff(array_keys($locales), [$detectedLanguage])
            : $postCreateDTO->selectedLanguages;

        if (empty($targetLanguages)) {
            Log::warning('No target languages found for translation.');

            return;
        }

        // Generate translations for each target language
        $translations = [];
        foreach ($targetLanguages as $locale) {
            $translations[$locale] = [
                'title' => $this->localizationService->translate($postCreateDTO->title, $detectedLanguage, $locale),
                'body' => $this->localizationService->translate($postCreateDTO->content, $detectedLanguage, $locale),
            ];
        }

        // Use the repository to save the post and its translations
        $this->writePostRepository->savePostAndTranslations($postCreateDTO, $translations);
    }

    public function deletePost(int $postId = null, array $selected = []): void
    {
        if ($postId) {
            // Single post deletion
            $this->writePostRepository->deletePostById($postId);
            Log::info("Post with ID {$postId} was deleted successfully.");
        } elseif (!empty($selected)) {
            // Batch post deletion
            $this->writePostRepository->deletePostsByIds($selected);
            Log::info('Selected posts were deleted successfully: ' . implode(', ', $selected));
        } else {
            throw new \Exception(__('posts.There are no posts selected!'));
        }
    }
}

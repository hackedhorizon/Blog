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
        // Check if localization is enabled.
        if (! config('services.should_have_localization')) {
            $this->writePostRepository->savePost($postCreateDTO);

            return;
        }

        // Detect the language of the post's title
        $detectedLanguage = strtolower($this->localizationService->detectLanguage($postCreateDTO->title));

        if (! $detectedLanguage) {
            throw new \Exception(__('posts.Language detection failed.'));
        }

        $postCreateDTO->detectedLanguage = $detectedLanguage;

        // Determine target languages for translation
        $targetLanguages = array_keys(config('app.locales', []));

        if (empty($targetLanguages)) {
            throw new \Exception(__('posts.No target languages found for translation.'));
        }

        // Filter out the detected language from the target languages
        $targetLanguages = array_filter($targetLanguages, fn ($locale) => $locale !== $detectedLanguage);

        $titleTranslations = $this->localizationService->translate($postCreateDTO->title, $detectedLanguage, $targetLanguages);
        $contentTranslations = $this->localizationService->translate($postCreateDTO->content, $detectedLanguage, $targetLanguages);

        // If the translation is empty in any case, we throw an exception
        if (empty($titleTranslations) || empty($contentTranslations)) {
            throw new \Exception('Translation failed.');
        }

        // Build the translations array
        $translations = array_combine($targetLanguages, array_map(function ($locale) use ($titleTranslations, $contentTranslations) {
            return [
                'title' => $titleTranslations[$locale] ?? '',
                'body' => $contentTranslations[$locale] ?? '',
            ];
        }, $targetLanguages));

        $this->writePostRepository->savePostAndTranslations($postCreateDTO, $translations);
    }

    public function deletePost(?int $postId = null, array $selected = []): void
    {
        if ($postId) {
            $this->writePostRepository->deletePostById($postId);
            Log::info("Post with ID {$postId} was deleted successfully.");
        } elseif (! empty($selected)) {
            $this->writePostRepository->deletePostsByIds($selected);
            Log::info('Selected posts were deleted successfully: '.implode(', ', $selected));
        } else {
            throw new \Exception(__('posts.There are no posts selected!'));
        }
    }
}

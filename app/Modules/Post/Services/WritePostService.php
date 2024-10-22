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
            $this->writePostRepository->savePost($postCreateDTO); // If it's disabled, then just create a post without translations.

            return;
        }

        // Handle the translation logic in a separate method
        $translations = $this->handlePostTranslation($postCreateDTO);

        // Save post with translations
        $this->writePostRepository->savePostAndTranslations($postCreateDTO, $translations);
    }

    public function updatePost(int $postId, array $data, array $categories): void
    {
        // Check if localization is enabled.
        if (! config('services.should_have_localization')) {
            $this->writePostRepository->updatePost($postId, $data, $categories, []);

            return;
        }

        // Detect the language of the post's title
        $detectedLanguage = strtolower($this->localizationService->detectLanguage($data['title']));

        if (! $detectedLanguage) {
            throw new \Exception(__('posts.Language detection failed.'));
        }

        // Store detected language inside DTO
        $data['detectedLanguage'] = $detectedLanguage;

        // Handle the translation logic for updates
        $translations = $this->handleUpdateTranslation($data);

        // Update post with translations
        $this->writePostRepository->updatePost($postId, $data, $categories, $translations);

        Log::info("Post with ID {$postId} was updated successfully.");
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

    private function handlePostTranslation(PostCreateDTO $postCreateDTO): array
    {
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
        return array_combine($targetLanguages, array_map(function ($locale) use ($titleTranslations, $contentTranslations) {
            return [
                'title' => $titleTranslations[$locale] ?? '',
                'body' => $contentTranslations[$locale] ?? '',
            ];
        }, $targetLanguages));
    }

    private function handleUpdateTranslation(array $data): array
    {
        // Detect the language of the updated post's title
        $detectedLanguage = strtolower($this->localizationService->detectLanguage($data['title']));

        if (! $detectedLanguage) {
            throw new \Exception(__('posts.Language detection failed.'));
        }

        // Determine target languages for translation
        $targetLanguages = array_keys(config('app.locales', []));

        if (empty($targetLanguages)) {
            throw new \Exception(__('posts.No target languages found for translation.'));
        }

        // Filter out the detected language from the target languages
        $targetLanguages = array_filter($targetLanguages, fn ($locale) => $locale !== $detectedLanguage);

        $titleTranslations = $this->localizationService->translate($data['title'], $detectedLanguage, $targetLanguages);
        $contentTranslations = $this->localizationService->translate($data['body'], $detectedLanguage, $targetLanguages);

        // If the translation is empty in any case, we throw an exception
        if (empty($titleTranslations) || empty($contentTranslations)) {
            throw new \Exception('Translation failed.');
        }

        // Build the translations array
        return array_combine($targetLanguages, array_map(function ($locale) use ($titleTranslations, $contentTranslations) {
            return [
                'title' => $titleTranslations[$locale] ?? '',
                'body' => $contentTranslations[$locale] ?? '',
            ];
        }, $targetLanguages));
    }
}

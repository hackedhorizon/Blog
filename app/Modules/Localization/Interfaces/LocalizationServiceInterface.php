<?php

namespace App\Modules\Localization\Interfaces;

/**
 * Interface LocalizationServiceInterface
 *
 * Represents an interface for localization services.
 */
interface LocalizationServiceInterface
{
    /**
     * Update the currently selected language.
     *
     * @param  int|null  $userId  The ID of the user (or null if not logged in)
     * @param  string  $language  The language code to set
     * @return bool True if the language update was successful, false otherwise
     */
    public function updateCurrentlySelectedLanguage(?int $userId, string $language): bool;

    /**
     * Get the application locale.
     *
     * @return string The current application locale
     */
    public function getAppLocale(): string;

    /**
     * Set the application locale.
     *
     * @param  string  $locale  The locale to set
     */
    public function setAppLocale(string $locale): void;

    /**
     * Translate text to a target language.
     */
    public function translate(string $text, string $from, array $to): array;

    /**
     * Detect the language of the given text.
     *
     * @return string|null The detected language code or null if detection fails.
     */
    public function detectLanguage(string $text): ?string;
}

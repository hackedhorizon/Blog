<?php

namespace App\Modules\Localization\Services;

use Alessiodh\Deepltranslator\Traits\DeepltranslatorTrait;
use App\Modules\Localization\Interfaces\LocalizationServiceInterface;
use App\Modules\UserManagement\Services\ReadUserService;
use App\Modules\UserManagement\Services\WriteUserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LocalizationService implements LocalizationServiceInterface
{
    use DeepltranslatorTrait;

    private WriteUserService $writeUserService;

    private ReadUserService $readUserService;

    public function __construct(WriteUserService $writeUserService, ReadUserService $readUserService)
    {
        $this->writeUserService = $writeUserService;
        $this->readUserService = $readUserService;
    }

    public function updateCurrentlySelectedLanguage(?int $userId, string $language): bool
    {
        if ($userId) {
            return $this->writeUserService->updateUser($userId, ['language' => $language]);
        }
        session()->put('locale', $language);

        return true;
    }

    public function getAppLocale(): string
    {
        return Auth::check()
            ? $this->getUserLocale(Auth::id())
            : session('locale', Config::get('app.locale'));
    }

    private function getUserLocale($userId): string
    {
        return $this->readUserService->getUserProperty('language', $userId) ?? Config::get('app.locale');
    }

    public function setAppLocale(string $locale): void
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }

    public function translate(string $text, string $from, array $to): array
    {
        try {

            $translated = $this->translateString($text, $from, $to);

            return (is_array($translated) && ! empty($translated)) ? $translated : [];
        } catch (\Throwable $th) {
            Log::error('Translation failed: '.$th->getMessage());

            return [];
        }
    }

    public function detectLanguage(string $text): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'DeepL-Auth-Key '.config('services.deepl_api_key'),
            ])->post('https://api-free.deepl.com/v2/translate', [
                'text' => [$text],
                'target_lang' => 'EN',
            ]);

            return $response->successful() && isset($response->json()['translations'][0]['detected_source_language'])
                ? $response->json()['translations'][0]['detected_source_language']
                : null;
        } catch (\Throwable $th) {
            Log::error('Error detecting language: '.$th->getMessage());

            return null;
        }
    }
}

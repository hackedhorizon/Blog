<?php

namespace App\Modules\Post\DTOs;

use DateTime;

class PostCreateDTO
{
    public function __construct(
        public string $title,
        public string $content,
        public string $detectedLanguage,
        public bool $published,
        public bool $featured,
        public DateTime $publicationDate,
        public array $selectedCategories,
    ) {}
}

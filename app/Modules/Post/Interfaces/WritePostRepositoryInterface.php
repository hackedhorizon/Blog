<?php

namespace App\Modules\Post\Interfaces;

use App\Modules\Post\DTOs\PostCreateDTO;

interface WritePostRepositoryInterface
{
    public function savePostAndTranslations(PostCreateDTO $postCreateDTO, array $translations): void;
}

<?php

namespace App\Modules\Post\Interfaces;

use App\Modules\Post\DTOs\PostCreateDTO;

interface WritePostServiceInterface
{
    public function createPost(PostCreateDTO $postCreateDTO): void;
}

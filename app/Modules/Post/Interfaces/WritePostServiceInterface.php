<?php

namespace App\Modules\Post\Interfaces;

use App\Modules\Post\DTOs\PostCreateDTO;

interface WritePostServiceInterface
{
    public function createPost(PostCreateDTO $postCreateDTO): void;

    public function updatePost(int $postId, array $data, array $categories): void;

    public function deletePost(?int $postId = null, array $selected = []): void;
}

<?php

namespace App\Modules\Post\Interfaces;

use App\Modules\Post\DTOs\PostCreateDTO;

interface WritePostRepositoryInterface
{
    public function savePost(PostCreateDTO $postCreateDTO);

    public function savePostAndTranslations(PostCreateDTO $postCreateDTO, array $translations): void;

    public function deletePostById(int $postId): void;

    public function deletePostsByIds(array $postIds): void;
}

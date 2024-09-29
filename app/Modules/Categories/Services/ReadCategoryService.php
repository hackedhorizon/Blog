<?php

namespace App\Modules\Categories\Services;

use App\Modules\Categories\Interfaces\ReadCategoryRepositoryInterface;
use App\Modules\Categories\Interfaces\ReadCategoryServiceInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ReadCategoryService
 * Handles the retrieval of categories.
 */
class ReadCategoryService implements ReadCategoryServiceInterface
{
    private ReadCategoryRepositoryInterface $readCategoryRepository;

    /**
     * ReadCategoryService constructor.
     *
     * @param ReadCategoryRepositoryInterface $readCategoryRepository
     */
    public function __construct(ReadCategoryRepositoryInterface $readCategoryRepository)
    {
        $this->readCategoryRepository = $readCategoryRepository;
    }

    /**
     * Get all categories.
     *
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->readCategoryRepository->getCategories();
    }
}

<?php

namespace App\Modules\Categories\Repositories;

use App\Models\Category;
use App\Modules\Categories\Interfaces\ReadCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ReadCategoryRepository implements ReadCategoryRepositoryInterface
{
    public function getCategories(): Collection
    {
        return Category::all();
    }
}

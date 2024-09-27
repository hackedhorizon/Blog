<?php

namespace App\Modules\Categories\Services;

use App\Models\Category;

class ReadCategoryService
{
    public function getCategories()
    {
        return Category::all();
    }
}

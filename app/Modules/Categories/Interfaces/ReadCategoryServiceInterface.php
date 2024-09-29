<?php

namespace App\Modules\Categories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ReadCategoryServiceInterface
{
    public function getCategories(): Collection;
}

<?php

namespace App\Modules\Categories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ReadCategoryRepositoryInterface
{
    public function getCategories(): Collection;
}

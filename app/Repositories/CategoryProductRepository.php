<?php

namespace App\Repositories;

use App\Models\CategoryProduct;

class CategoryProductRepository
{
    public function getAll()
    {
        return CategoryProduct::all();
    }
}
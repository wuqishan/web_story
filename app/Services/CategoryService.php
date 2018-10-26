<?php

namespace App\Services;

use App\Models\Category;

class CategoryService extends Service
{
    public function getCategory($id = 0)
    {
        if ($id === 0) {
            $category = Category::all();
        } else {
            $category = Category::find($id);
        }

        return $category;
    }
}
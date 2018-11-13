<?php

namespace App\Models;

use App\Helper\CacheHelper;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    public $timestamps = false;

    public static function getAll()
    {
        $cache_key = 'category_all';
        if (CacheHelper::has($cache_key)) {
            $category = CacheHelper::get($cache_key);
        } else {
            $category = self::all(['id', 'name'])->toArray();
            CacheHelper::set($cache_key, $category);
        }

        return $category;
    }

    public static function categoryMap($category_id)
    {
        $results = self::getAll();
        $ids = array_column($results, 'id');
        $names = array_column($results, 'name');
        $category = array_combine($ids, $names);

        return $category[$category_id];
    }
}

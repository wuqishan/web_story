<?php

namespace App\Models;

use App\Helper\CacheHelper;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    public $timestamps = false;

    public static function categoryMap($category_id)
    {
        $cache_key = 'category_info';
        if (CacheHelper::has($cache_key)) {
            $category = CacheHelper::get($cache_key);
        } else {
            $results = self::all(['id', 'name'])->toArray();
            $ids = array_column($results, 'id');
            $names = array_column($results, 'name');
            $category = array_combine($ids, $names);
            CacheHelper::set($cache_key, $category);
        }

        return $category[$category_id];
    }
}

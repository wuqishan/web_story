<?php

namespace App\Models;

use App\Helper\CacheHelper;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'author';

    public $timestamps = false;

    public static function getAuthorId($author_name)
    {
        $author_id = 0;
        if (! empty($author_name)) {
            $author = Author::where('name', $author_name)->first();
            if (! empty($author)) {
                $author_id = $author->id;
            } else {
                $author_id = Author::insertGetId(['name' => $author_name]);
            }
        }

        return $author_id;
    }

    public static function getAll()
    {
        $cache_key = 'author_all';
        if (CacheHelper::has($cache_key)) {
            $author = CacheHelper::get($cache_key);
        } else {
            $author = self::all(['id', 'name'])->toArray();
            CacheHelper::set($cache_key, $author);
        }

        return $author;
    }
}

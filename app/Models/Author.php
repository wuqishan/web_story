<?php

namespace App\Models;

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
}

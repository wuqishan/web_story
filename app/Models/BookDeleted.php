<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookDeleted extends Model
{
    protected $table = 'book_deleted';

    public $timestamps = false;

    public static $finishedMap = [
        '0' => '否',
        '1' => '是'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';

    public $timestamps = true;

    public static $finishedMap = [
        '0' => '否',
        '1' => '是'
    ];
}

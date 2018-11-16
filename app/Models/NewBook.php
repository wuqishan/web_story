<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewBook extends Model
{
    protected $table = 'new_book';

    public $timestamps = true;

    public static $finishedMap = [
        '0' => '否',
        '1' => '是'
    ];
}

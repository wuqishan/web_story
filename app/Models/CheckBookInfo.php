<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckBookInfo extends Model
{
    protected $table = 'check_book_info';

    public $timestamps = false;

    public static $statusMap = [
        '1' => '未解决',
        '2' => '已解决'
    ];

    public static $methodMap = [
        '1' => '未做分配',
        '2' => '章节删除重抓',
        '3' => '本书完全删除'
    ];
}

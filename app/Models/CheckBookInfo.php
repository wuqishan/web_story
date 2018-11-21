<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckBookInfo extends Model
{
    protected $table = 'check_book_info';

    public $timestamps = false;

    public static $messageIdMap = [
        '1' => 'CategoryID分类异常',
        '2' => '书本无章节信息',
        '3' => '书本抓取章节排序异常',
        '4' => '书本章节连表异常',
        '5' => '书本章节内容记录不存在',
        '6' => '书本最新章节错误异常',
        '7' => '书本可能已经完本',
    ];

    public static $statusMap = [
        '1' => '未解决',
        '2' => '已解决'
    ];
}

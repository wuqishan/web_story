<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportLog extends Model
{
    protected $table = 'import_log';

    public $timestamps = false;

    public static $typeMap = [
        '1' => '书本',
        '2' => '章节',
    ];
}

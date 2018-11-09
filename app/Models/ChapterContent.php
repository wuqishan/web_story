<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChapterContent extends Model
{
    protected $table = 'chapter_content_%d';

    public $timestamps = false;

    /**
     * 重写setTable
     *
     * @param integer $category_id
     * @return $this
     */
    public function setTable($category_id)
    {
        $this->table = sprintf($this->table, (int) $category_id);

        return $this;
    }
}

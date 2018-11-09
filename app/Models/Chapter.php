<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $table = 'chapter_%d';

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

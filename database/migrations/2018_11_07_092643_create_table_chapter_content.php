<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableChapterContent extends Migration
{
    /**
     * content 对应 chapter表 需要分表操作，这里配置分表的数量和后缀名称
     *
     * @var array
     */
    public $table_index = [1, 2, 3, 4, 5, 6, 7];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->table_index as $index) {
            $table_name = 'chapter_content_' . $index;
            Schema::create($table_name, function (Blueprint $table) {
                $table->increments('id');
                $table->text('content')->comment('章节内容');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->table_index as $index) {
            $table_name = 'chapter_content_' . $index;
            Schema::drop($table_name);
        }
    }
}

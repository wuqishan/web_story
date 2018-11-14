<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableChapterAddIsNew extends Migration
{
    /**
     * chapter 需要分表操作，这里配置分表的数量和后缀名称
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
            $table_name = 'chapter_' . $index;
            Schema::table($table_name, function (Blueprint $table) {
                $table->tinyInteger('is_new')
                    ->default(0)
                    ->after('orderby')
                    ->comment('是否是刚抓取的，默认是0，记录好log后更新为1');
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
            $table_name = 'chapter_' . $index;
            Schema::create($table_name, function (Blueprint $table) {
                $table->drop_column('is_new');
            });
        }
    }
}

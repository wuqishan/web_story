<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCheckBookInfoAddMessageId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_book_info', function (Blueprint $table) {
            $table->integer('message_id')
                ->after('message')
                ->default('0')
                ->comment('1:CategoryID分类异常,2:书本无章节信息,3:书本抓取章节排序异常,4:书本章节连表异常,5:书本章节内容记录不存在,6:书本最新章节错误异常,7:书本可能已经完本');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUpdateChapter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('update_chapter', function (Blueprint $table) {
            $table->increments('id');
            $table->char('book_unique_code', 32)->default('')->comment('所属书本的唯一码');
            $table->char('unique_code', 32)->default('')->comment('本章节的唯一码');
            $table->char('prev_unique_code', 32)->default('')->comment('前一章的唯一码');
            $table->char('next_unique_code', 32)->default('')->comment('后一章的唯一码');
            $table->string('title', 128)->default('')->comment('本章节标题');
            $table->integer('view', false, true)->default(0)->comment('点击量');
            $table->integer('category_id', false, true)->default(0)->comment('所属书本分类');
            $table->string('url', 128)->default('')->comment('本章节的源地址');
            $table->integer('number_of_words', false)->default(0)->comment('本章节的字数');
            $table->integer('orderby', false, true)->default(0)->comment('排序');
            $table->tinyInteger('is_new')->default(0)->comment('是否是刚抓取的，默认是0，记录好log后更新为1');
            $table->timestamps();
            $table->index('book_unique_code', 'book_unique_code_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('update_chapter');
    }
}

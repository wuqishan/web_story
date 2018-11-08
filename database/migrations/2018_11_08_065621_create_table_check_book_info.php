<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCheckBookInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_book_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('book_title', 128)->default('')->comment('书本标题');
            $table->integer('book_id', false, true)->default(0)->comment('书本ID');
            $table->integer('book_category_id', false, true)->default(0)->comment('书本分类');
            $table->string('book_url', 128)->default('')->comment('书本的源地址');
            $table->char('book_unique_code', 32)->default('')->comment('书本的唯一码');
            $table->char('newest_chapter', 32)->default('')->comment('最新章节的唯一码');
            $table->string('message', 255)->default('')->comment('监测信息');
            $table->tinyInteger('status')->default(0)->comment('状态，1：未解决；2：已解决；');
            $table->tinyInteger('method')->default(0)->comment('解决方法，1：未做分配；2：章节删除重抓；3：本书完全删除');
            $table->dateTime('created_at')->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('check_book_info');
    }
}

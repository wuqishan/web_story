<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book', function (Blueprint $table) {
            $table->increments('id');
            $table->char('unique_code', 32)->default('')->comment('本书籍唯一码');
            $table->string('title', 128)->default('')->comment('书名');
            $table->string('author', 128)->default('')->comment('作者');
            $table->dateTime('last_update')->comment('最近更新时间');
            $table->text('description')->comment('描述');
            $table->string('image_local_url', 128)->default('')->comment('本地图片地址');
            $table->string('image_origin_url', 128)->default('')->comment('远程图片地址');
            $table->string('url', 128)->default('')->comment('本书的源地址');
            $table->tinyInteger('finished')->default(0)->comment('是否完本');
            $table->integer('category_id', false, true)->default(0)->comment('本书分类');
            $table->integer('author_id', false, true)->default(0)->comment('作者ID');
            $table->integer('view', false, true)->default(0)->comment('点击量');
            $table->char('newest_chapter', 32)->default('')->comment('本书最新章节的唯一码');
            $table->tinyInteger('is_new')->default(0)->comment('是否是刚抓取的，默认是0，记录好log后更新为1');
            $table->timestamps();
            $table->unique('unique_code', 'unique_code_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('book');
    }
}

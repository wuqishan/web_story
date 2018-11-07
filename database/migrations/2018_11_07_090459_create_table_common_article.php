<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCommonArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_article', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 128)->default('')->comment('文章标题');
            $table->text('content')->comment('文章内容');
            $table->string('type', 128)->default('')->comment('文章类型，备用字段');
            $table->tinyInteger('orderby', false, true)->default(0)->comment('文章排序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('common_article');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFriendLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_link', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 128)->default('')->comment('友链标题');
            $table->string('link', 128)->default('')->comment('友链地址');
            $table->string('description', 512)->default('')->comment('友链描述');
            $table->tinyInteger('deleted')->default(0)->comment('是否删除');
            $table->tinyInteger('orderby', false, true)->default(0)->comment('友链排序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('friend_link');
    }
}

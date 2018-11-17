<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableImportLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_log', function (Blueprint $table) {
            $table->increments('id');
//            $table->char('flag', 32)->default('')->comment('导入的一个flag，每次导入都是一个不同的flag');
            $table->integer('number')->default(0)->comment('导入目标的数量');
            $table->tinyInteger('type', false, true)->default(0)->comment('本次导入类型, 1: 书本导入, 2: 章节导入');
            $table->mediumText('content')->comment('导入目标的数据，一般存category_id和目标的id json字符串');
            $table->tinyInteger('status', false, true)->comment('导入状态，备用字段');
            $table->dateTime('created_at')->comment('导入时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('import_log');
    }
}

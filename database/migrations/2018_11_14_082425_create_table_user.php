<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 64)->default('')->comment('用户名');
            $table->char('password', 32)->default('')->comment('密码');
            $table->string('email', 128)->default('')->comment('邮箱');
            $table->string('nickname', 128)->default('')->comment('昵称');
            $table->dateTime('latest_login_time')->comment('最近登录的时间');
            $table->string('latest_login_ip', 8)->default('')->comment('最近登录的IP');
            $table->char('salt', 8)->default('')->comment('盐');
            $table->string('openid', 128)->default('')->comment('微信openid');
            $table->tinyInteger('status')->default(0)->comment('用戶状态, 1: 正常, 2: 禁用');
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
        Schema::drop('user');
    }
}

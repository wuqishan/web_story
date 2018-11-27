<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBookAddNumberOfWords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book', function (Blueprint $table) {
            $table->integer('number_of_words', false, true)
                ->after('newest_chapter')
                ->default('0')
                ->comment('本书到目前为止总字数');
        });
        Schema::table('new_book', function (Blueprint $table) {
            $table->integer('number_of_words', false, true)
                ->after('newest_chapter')
                ->default('0')
                ->comment('本书到目前为止总字数');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameListsToStacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //外部キーがlist_userになってしまうのため一旦カラムを削除
        Schema::table('lists', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::rename('lists','stacks');

        //外部キーを改めて設定
        Schema::table('stacks', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('stacks','lists');
    }
}

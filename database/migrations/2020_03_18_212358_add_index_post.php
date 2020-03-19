<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['user_id']);
            $table->index(['title']);
            $table->index(['slug']);
            $table->index(['category_id']);
            $table->index(['enabled']);
            $table->index(['monetized']);
        });

        Schema::table('post_categories', function (Blueprint $table) {
            $table->index(['name']);
            $table->index(['slug']);
            $table->index(['enabled']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['title']);
            $table->dropIndex(['slug']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['enabled']);
            $table->dropIndex(['monetized']);
        });

        Schema::table('post_categories', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['slug']);
            $table->dropIndex(['enabled']);
        });
    }
}

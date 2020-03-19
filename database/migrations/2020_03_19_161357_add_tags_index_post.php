<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTagsIndexPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('tags');
        });

        Schema::table('post_tags', function (Blueprint $table) {
            $table->index(['name']);
            $table->index(['slug']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->index(['tags']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('post_tags');
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('tags');
        });
        Schema::table('post_tags', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['slug']);
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['tags']);
        });
    }
}

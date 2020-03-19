<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PostAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Add these new fields to Blog Post table
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('category_id');
            $table->boolean('enabled');
            $table->boolean('monetized');
            $table->integer('hits');
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
            $table->dropColumn('category_id');
            $table->dropColumn('enabled');
            $table->dropColumn('monetized');
            $table->dropColumn('hits');
        });
    }
}

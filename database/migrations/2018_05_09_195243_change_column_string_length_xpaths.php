<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnStringLengthXpaths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('xpaths', function (Blueprint $table) {
          $table->string('title_path', 1000)->change();
          $table->string('image_path', 1000)->change();
          $table->string('price_path', 1000)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('xpaths', function (Blueprint $table) {
          $table->string('title_path')->change();
          $table->string('image_path')->change();
          $table->string('price_path')->change();
        });
    }
}

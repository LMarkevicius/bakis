<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnsToXpathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('xpaths', function (Blueprint $table) {
          $table->string('status')->after('price_path')->nullable();
          $table->date('check_date')->after('status')->nullable();
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
          $table->dropColumn('status');
          $table->dropColumn('check_date');
        });
    }
}

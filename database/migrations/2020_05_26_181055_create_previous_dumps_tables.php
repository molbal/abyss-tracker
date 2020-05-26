<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreviousDumpsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previous_dumps_tables', function (Blueprint $table) {
            $table->string("TABLE_NAME", 32)->primary();
            $table->unsignedSmallInteger("ORDER_ASC");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('previous_dumps_tables');
    }
}

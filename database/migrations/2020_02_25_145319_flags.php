<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Flags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('run_report', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("REPORTER_CHAR_ID");
            $table->unsignedInteger("RUN_ID")->unique();
            $table->string("MESSAGE", 1024);
            $table->boolean("PROCESSED");
            $table->timestamp("CREATED_AT")->useCurrent()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('run_report');
    }
}

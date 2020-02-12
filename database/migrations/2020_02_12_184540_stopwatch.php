<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Stopwatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("stopwatch", function(Blueprint $t) {
            $t->unsignedBigInteger("CHAR_ID")->primary();
            $t->dateTime("ENTERED_ABYSS")->nullable();
            $t->dateTime("EXITED_ABYSS")->nullable();
            $t->boolean("IN_ABYSS");
            $t->dateTime("EXPIRE");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("stopwatch");
    }
}

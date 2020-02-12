<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Forevercache extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("forevercache", function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger("ID")->primary();
            $table->timestamp("created_at")->useCurrent();
            $table->string("Name", 256)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("forevercache");
    }
}

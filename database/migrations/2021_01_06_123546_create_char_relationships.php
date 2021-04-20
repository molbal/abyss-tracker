<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('char_relationships', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('main');
            $table->bigInteger('alt');
            $table->timestamps();

            $table->foreign('main')->on('chars')->references('CHAR_ID');
            $table->foreign('alt')->on('chars')->references('CHAR_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('char_relationships');
    }
}

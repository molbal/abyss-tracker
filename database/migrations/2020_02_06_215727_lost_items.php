<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LostItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lost_items', function (Blueprint $t) {
            $t->bigIncrements("ID");
            $t->unsignedBigInteger("ITEM_ID");
            $t->integer("RUN_ID");
            $t->unsignedInteger("COUNT");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lost_items');
    }
}

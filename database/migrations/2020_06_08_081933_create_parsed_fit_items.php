<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParsedFitItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parsed_fit_items', function (Blueprint $table) {
            $table->unsignedBigInteger("FIT_ID")->index();
            $table->unsignedBigInteger("ITEM_ID");
            $table->unsignedInteger("COUNT")->default(1);
            $table->unsignedBigInteger("AMMO_ID")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parsed_fit_items');
    }
}

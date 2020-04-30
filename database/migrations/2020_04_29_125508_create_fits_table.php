<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fits', function (Blueprint $table) {
            $table->bigIncrements("ID");
            $table->bigInteger("CHAR_ID")->comment("Fit owner");
            $table->unsignedBigInteger("SHIP_ID");
            $table->string("NAME", "64");
            $table->longText("DESCRIPTION");
            $table->json("STATS");
            $table->enum("STATUS", ["QUEUED", "DONE", "FAULT"]);
            $table->unsignedBigInteger("PRICE");
            $table->mediumText("RAW_EFT");
            $table->timestamp("SUBMITTED");

            $table->index("SHIP_ID");
            $table->index("PRICE");
            $table->foreign("CHAR_ID")->references("CHAR_ID")->on("chars");
            $table->foreign("SHIP_ID")->references("ID")->on("ship_lookup");
        });

        Schema::create("fit_recommendations", function (Blueprint $table) {
            $table->unsignedBigInteger("FIT_ID");
            $table->unsignedSmallInteger("ELECTRICAL");
            $table->unsignedSmallInteger("DARK");
            $table->unsignedSmallInteger("EXOTIC");
            $table->unsignedSmallInteger("FIRESTORM");
            $table->unsignedSmallInteger("GAMMA");

            $table->foreign("FIT_ID")->references("ID")->on("fits");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fit_recommendations');
        Schema::dropIfExists('fits');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleSlotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_slot', function (Blueprint $table) {
            $table->unsignedBigInteger("ITEM_ID");
            $table->enum("ITEM_SLOT", [
                "high", "mid", "low", "rig", "drone", "ammo", "cargo", "booster", "implant"
            ]);


            $table->foreign("ITEM_ID")->references("ITEM_ID")->on("item_prices");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_slot');
    }
}

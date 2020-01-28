<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendRunsInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("runs",function (Blueprint $t) {
            $t->bigInteger("SHIP_ID")->nullable()->index();
            $t->enum("DEATH_REASON", [
                'TIMEOUT',
                'TANK_FAILED',
                'CONNECTION_DROP',
                'PILOTING_FAIL',
                'PVP_DEATH',
                'OVERHEAT_FAILURE'
            ])->nullable();
            $t->boolean("PVP_CONDUIT_USED")->nullable();
            $t->boolean("PVP_CONDUIT_SPAWN")->nullable();
            $t->unsignedInteger("FILAMENT_PRICE")->nullable();
        });

        Schema::create("detailed_loot", function (Blueprint $t) {
           $t->bigIncrements("ID");
           $t->unsignedBigInteger("ITEM_ID");
           $t->unsignedInteger("COUNT");
           $t->timestamp("PRICE_LAST_UPDATED")->useCurrent()->index();
           $t->integer("RUN_ID");
           $t->enum("TYPE", [
               "RED_LOOT", "BLUEPRINT", "SKILLBOOK", "MATERIAL", "OTHER"
           ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("runs",function (Blueprint $t) {
            $t->removeColumn("SHIP_ID");
            $t->removeColumn("DEATH_REASON");
            $t->removeColumn("PVP_CONDUIT_USED");
            $t->removeColumn("PVP_CONDUIT_SPAWN");
            $t->removeColumn("FILAMENT_PRICE");
        });

        Schema::dropIfExists("detailed_loot");
    }
}

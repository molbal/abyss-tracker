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
                'PILOTING_MISTAKE',
                'PVP_DEATH',
                'OVERHEAT_FAILURE',
                'EXPERIMENTAL_FIT',
                'OTHER'
            ])->nullable();
            $t->boolean("PVP_CONDUIT_USED")->nullable();
            $t->boolean("PVP_CONDUIT_SPAWN")->nullable();
            $t->unsignedInteger("FILAMENT_PRICE")->nullable();
            $t->enum("LOOT_TYPE", [
                "BIOADAPTIVE_ONLY",
                "BIOADAPTIVE_PLUS_SOME_CANS",
                "BIOADAPTIVE_PLUS_MOST_CANS",
                "BIOADAPTIVE_PLUS_ALL_CANS"
            ])->nullable();
            $t->string("KILLMAIL", 128)->nullable();
            $t->timestamp("CREATED_AT")->useCurrent()->index();
        });

        Schema::create("detailed_loot", function (Blueprint $t) {
           $t->bigIncrements("ID");
           $t->unsignedBigInteger("ITEM_ID");
            $t->integer("RUN_ID");
            $t->unsignedInteger("COUNT");
        });

        Schema::create("item_prices", function (Blueprint $t) {
            $t->unsignedBigInteger("ITEM_ID")->primary();
            $t->unsignedBigInteger("PRICE");
            $t->timestamp("PRICE_LAST_UPDATED")->useCurrent()->index();
            $t->enum("TYPE", [
                "RED_LOOT", "BLUEPRINT", "SKILLBOOK", "MATERIAL", "OTHER"
            ])->nullable();
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
            $t->removeColumn("LOOT_TYPE");
            $t->removeColumn("KILLMAIL");
            $t->removeColumn("CREATED_AT");
        });

        Schema::dropIfExists("detailed_loot");
        Schema::dropIfExists("item_prices");
    }
}

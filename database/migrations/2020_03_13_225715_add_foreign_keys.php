<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * AddForeignKeys constructor.
     */
    public function __construct() {
        DB::getDoctrineSchemaManager()
          ->getDatabasePlatform()
          ->registerDoctrineTypeMapping('enum', 'string');
    }


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        try {
            Schema::table("runs", function (Blueprint $table) {
            $table->dropForeign("CHAR_ID");
            });
        }
        catch (Exception $e) {

        }
        Schema::table("runs", function (Blueprint $table) {
           $table->foreign("CHAR_ID")->references("CHAR_ID")->on("chars");
           $table->unsignedBigInteger("SHIP_ID")->change();
           $table->foreign("SHIP_ID")->references("ID")->on("ship_lookup");
        });

        Schema::table("detailed_loot", function (Blueprint $table) {
            $table->unsignedInteger("RUN_ID")->change();
        });
        Schema::table("detailed_loot", function (Blueprint $table) {
            $table->foreign("ITEM_ID")->references("ITEM_ID")->on("item_prices");
            $table->foreign("RUN_ID")->references("ID")->on("runs");
        });

        Schema::table("lost_items", function (Blueprint $table) {
            $table->unsignedInteger("RUN_ID")->change();
        });

        Schema::table("lost_items", function (Blueprint $table) {
            $table->foreign("ITEM_ID")->references("ITEM_ID")->on("item_prices");
            $table->foreign("RUN_ID")->references("ID")->on("runs");
        });

        Schema::table("stopwatch", function (Blueprint $table) {
            $table->unsignedBigInteger("CHAR_ID")->change();
            $table->foreign("CHAR_ID")->references("CHAR_ID")->on("chars");
        });


        Schema::table("run_report", function (Blueprint $table) {
            $table->foreign("RUN_ID")->references("ID")->on("runs");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("runs", function (Blueprint $table) {
            $table->dropForeign("CHAR_ID");
            $table->bigInteger("SHIP_ID")->change();
            $table->dropForeign("SHIP_ID");
        });

        Schema::table("detailed_loot", function (Blueprint $table) {
            $table->unsignedBigInteger("RUN_ID")->change();
            $table->dropForeign("ITEM_ID");
            $table->dropForeign("RUN_ID");
        });

        Schema::table("lost_items", function (Blueprint $table) {
            $table->unsignedBigInteger("RUN_ID")->change();
            $table->dropForeign("ITEM_ID");
            $table->dropForeign("RUN_ID");
        });

        Schema::table("stopwatch", function (Blueprint $table) {
            $table->bigInteger("CHAR_ID")->change();
            $table->dropForeign("CHAR_ID");
        });

        Schema::table("run_report", function (Blueprint $table) {
            $table->dropForeign("RUN_ID");
        });
    }
}

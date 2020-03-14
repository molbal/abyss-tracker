<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

    class AddForeignKeys extends Migration {
        /**
         * AddForeignKeys constructor.
         */
        public function __construct() {
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        }


        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {

            Schema::table("runs", function (Blueprint $table) {
                $table->unsignedBigInteger("SHIP_ID")->change();
            });

            Schema::table("detailed_loot", function (Blueprint $table) {
                $table->unsignedInteger("RUN_ID")->change();
            });


            Schema::table("lost_items", function (Blueprint $table) {
                $table->unsignedInteger("RUN_ID")->change();
            });


            Schema::table("stopwatch", function (Blueprint $table) {
                $table->unsignedBigInteger("CHAR_ID")->change();
            });


        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::table("runs", function (Blueprint $table) {
                $table->bigInteger("SHIP_ID")->change();
            });


            Schema::table("detailed_loot", function (Blueprint $table) {
                $table->unsignedBigInteger("RUN_ID")->change();
            });


            Schema::table("lost_items", function (Blueprint $table) {
                $table->unsignedBigInteger("RUN_ID")->change();
            });


            Schema::table("stopwatch", function (Blueprint $table) {
                $table->bigInteger("CHAR_ID")->change();
            });
            Schema::table("stopwatch", function (Blueprint $table) {
                $table->dropForeign("CHAR_ID");
            });


        }
    }

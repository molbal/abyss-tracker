<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class DoAddForeignKeys extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::table("runs", function (Blueprint $table) {
                $table->foreign("CHAR_ID")->references("CHAR_ID")->on("chars");
                $table->foreign("SHIP_ID")->references("ID")->on("ship_lookup");
            });

            Schema::table("detailed_loot", function (Blueprint $table) {
                $table->foreign("ITEM_ID")->references("ITEM_ID")->on("item_prices");
                $table->foreign("RUN_ID")->references("ID")->on("runs");
            });
            Schema::table("lost_items", function (Blueprint $table) {
                $table->foreign("ITEM_ID")->references("ITEM_ID")->on("item_prices");
                $table->foreign("RUN_ID")->references("ID")->on("runs");
            });
            Schema::table("stopwatch", function (Blueprint $table) {
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
        public function down() {
            Schema::table("runs", function (Blueprint $table) {
                $table->dropForeign("CHAR_ID");
                $table->dropForeign("SHIP_ID");
            });
            Schema::table("detailed_loot", function (Blueprint $table) {
                $table->dropForeign("ITEM_ID");
                $table->dropForeign("RUN_ID");
            });
            Schema::table("lost_items", function (Blueprint $table) {
                $table->dropForeign("ITEM_ID");
                $table->dropForeign("RUN_ID");
            });
            Schema::table("run_report", function (Blueprint $table) {
                $table->dropForeign("RUN_ID");
            });
        }
    }

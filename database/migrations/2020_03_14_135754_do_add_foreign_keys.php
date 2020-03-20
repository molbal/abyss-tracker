<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

    class DoAddForeignKeys extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
            try {DB::statement("alter table `runs` add constraint `runs_char_id_foreign` foreign key (`CHAR_ID`) references `chars` (`CHAR_ID`)");}catch (Exception $e) {echo $e->getMessage()."<br/>";}
            try {DB::statement("alter table `runs` add constraint `runs_ship_id_foreign` foreign key (`SHIP_ID`) references `ship_lookup` (`ID`)");}catch (Exception $e) {echo $e->getMessage()."<br/>";}

            try {DB::statement("alter table `detailed_loot` add constraint `dl_item_id_foreign` foreign key (`ITEM_ID`) references `item_prices` (`ITEM_ID`)");}catch (Exception $e) {echo $e->getMessage()."<br/>";}
            try {DB::statement("alter table `detailed_loot` add constraint `dl_run_id_foreign` foreign key (`RUN_ID`) references `runs` (`ID`)");}catch (Exception $e) {echo $e->getMessage()."<br/>";}

            try {DB::statement("alter table `lost_items` add constraint `li_item_id_foreign` foreign key (`ITEM_ID`) references `item_prices` (`ITEM_ID`)");}catch (Exception $e) {echo $e->getMessage()."<br/>";}
            try {DB::statement("alter table `lost_items` add constraint `li_run_id_foreign` foreign key (`RUN_ID`) references `runs` (`ID`)");}catch (Exception $e) {echo $e->getMessage()."<br/>";}

            try {DB::statement("alter table `stopwatch` add constraint `stopwatch_char_id_foreign` foreign key (`CHAR_ID`) references `chars` (`CHAR_ID`)");}catch (Exception $e) {echo $e->getMessage()."<br/>";}

            try {DB::statement("alter table `run_report` add constraint `rr_char_id_foreign` foreign key (`REPORTER_CHAR_ID`) references `chars` (`CHAR_ID`)");}catch (Exception $e) {echo $e->getMessage()."<br/>";}

            try {DB::statement("alter table `droprates_cache` add constraint `drc_item_id_foreign` foreign key (`ITEM_ID`) references `item_prices` (`ITEM_ID`)");}catch (Exception $e) {echo $e->getMessage()."<br/>";}

            try {DB::statement("alter table `privacy` add constraint `privacy_char_id_foreign` foreign key (`CHAR_ID`) references `chars` (`CHAR_ID`)");}catch (Exception $e) {echo $e->getMessage()."<br/>";}

            DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
//            Schema::table("runs", function (Blueprint $table) {
//                $table->dropForeign("CHAR_ID");
//                $table->dropForeign("SHIP_ID");
//            });
//            Schema::table("detailed_loot", function (Blueprint $table) {
//                $table->dropForeign("ITEM_ID");
//                $table->dropForeign("RUN_ID");
//            });
//            Schema::table("lost_items", function (Blueprint $table) {
//                $table->dropForeign("ITEM_ID");
//                $table->dropForeign("RUN_ID");
//            });
//            Schema::table("run_report", function (Blueprint $table) {
//                $table->dropForeign("RUN_ID");
//            });
//            Schema::table("stopwatch", function (Blueprint $table) {
//                $table->bigInteger("CHAR_ID")->change();
//            });
//            Schema::table("stopwatch", function (Blueprint $table) {
//                $table->dropForeign("CHAR_ID");
//            });
        }
    }

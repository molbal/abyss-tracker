<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class DropratesCache extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('droprates_cache', function (Blueprint $t) {
            $t->unsignedBigInteger("ITEM_ID");
            $t->enum("TIER", ['1', '2', '3', '4', '5'])->nullable();
            $t->enum("TYPE", ['Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma'])->nullable();
            $t->unsignedInteger("DROPPED_COUNT");
            $t->unsignedInteger("RUNS_COUNT");
            $t->timestamp("UPDATED_AT")->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $t->primary(["ITEM_ID", "TIER", "TYPE"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('droprates_cache');
    }
}

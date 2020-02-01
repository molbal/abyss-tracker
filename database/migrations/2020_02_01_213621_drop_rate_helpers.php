<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class DropRateHelpers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("tier");
        Schema::dropIfExists("type");
        Schema::create("tier", function (Blueprint $t) {
            $t->integer("TIER");
        });
        Schema::create("type", function (Blueprint $t) {
            $t->string("TYPE", 16);
        });
        DB::table("tier")->insert([["TIER" => 1],["TIER" => 2],["TIER" => 3],["TIER" => 4],["TIER" => 5]]);
        DB::table("type")->insert([["TYPE" => 'Electrical'], ["TYPE" => 'Dark'], ["TYPE" => 'Exotic'], ["TYPE" => 'Firestorm'], ["TYPE" => 'Gamma']]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("tier");
        Schema::dropIfExists("type");
    }
}

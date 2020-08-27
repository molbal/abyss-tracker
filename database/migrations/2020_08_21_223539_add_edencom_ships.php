<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class AddEdencomShips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table("ship_lookup")
          ->insert([
              ["ID" => 54732, "NAME" => "Stormbringer", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
              ["ID" => 54731, "NAME" => "Skybreaker", "GROUP" => "Frigate", "IS_CRUISER" => 0]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table("ship_lookup")
            ->whereIn("ID", [54732, 54731])
          ->delete();
    }
}

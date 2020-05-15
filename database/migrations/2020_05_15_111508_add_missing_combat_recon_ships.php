<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class AddMissingCombatReconShips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table("ship_lookup")->insert(["NAME"=>"Rook", "ID" => "11959", "GROUP"=>"Combat Recon Ship", "IS_CRUISER"=>1]);
        DB::table("ship_lookup")->insert(["NAME"=>"Curse", "ID" => "20125", "GROUP"=>"Combat Recon Ship", "IS_CRUISER"=>1]);
        DB::table("ship_lookup")->insert(["NAME"=>"Lachesis", "ID" => "11971", "GROUP"=>"Combat Recon Ship", "IS_CRUISER"=>1]);
        DB::table("ship_lookup")->insert(["NAME"=>"Huginn", "ID" => "11961", "GROUP"=>"Combat Recon Ship", "IS_CRUISER"=>1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

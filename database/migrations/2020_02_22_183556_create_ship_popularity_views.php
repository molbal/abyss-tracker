<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class CreateShipPopularityViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS v_ship_run_count');
        DB::statement("
        CREATE VIEW v_ship_run_count AS
        select COUNT(ID) as RUNS, TIER, TYPE, SHIP_ID from runs where SHIP_ID is not null group by SHIP_ID, TYPE, TIER;
        ");

        DB::statement('DROP VIEW IF EXISTS v_tt_run_count');
        DB::statement("
        CREATE VIEW v_tt_run_count AS
        select COUNT(ID) as RUNS, TIER, TYPE from runs where SHIP_ID is not null group by TYPE, TIER;
        ");

        DB::statement('DROP VIEW IF EXISTS v_ship_run_percent');
        DB::statement("create view v_ship_run_percent as 
        select src.TIER, src.TYPE, src.SHIP_ID, src.RUNS as SHIP_RUNS, trc.RUNS as ALL_RUNS, src.RUNS/trc.RUNS*100 as SHIP_PERCENT from v_ship_run_count src right join v_tt_run_count trc on src.TIER = trc.TIER and src.TYPE = trc.TYPE;
        ");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS v_ship_run_count');
        DB::statement('DROP VIEW IF EXISTS v_tt_run_count');
        DB::statement('DROP VIEW IF EXISTS v_ship_run_percent');
    }
}

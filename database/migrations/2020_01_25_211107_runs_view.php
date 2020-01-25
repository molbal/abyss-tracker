<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class RunsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW v_runall AS
        SELECT r.`ID`,
       r.`CHAR_ID`,
       r.`PUBLIC`,
       r.`TIER`,
       r.`TYPE`,
       r.`LOOT_ISK`,
       r.`SURVIVED`,
       r.`RUN_DATE`,
       c.`NAME`
FROM `runs` r
INNER JOIN `chars` c ON r.`CHAR_ID`=c.`CHAR_ID`;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS v_runall');
    }
}

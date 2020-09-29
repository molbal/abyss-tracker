<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;
    use Symfony\Component\Console\Output\ConsoleOutput;

    class AdjustViewsForDestroyers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $consoleOutput = new ConsoleOutput();

        $consoleOutput->writeln("Recreating view: v_runall");
        DB::beginTransaction();
        DB::unprepared("create or replace view v_runall as
select `r`.`ID`              AS `ID`,
       `r`.`CHAR_ID`         AS `CHAR_ID`,
       `r`.`PUBLIC`          AS `PUBLIC`,
       `r`.`TIER`            AS `TIER`,
       `r`.`TYPE`            AS `TYPE`,
       `r`.`LOOT_ISK`        AS `LOOT_ISK`,
       `r`.`SURVIVED`        AS `SURVIVED`,
       `r`.`RUN_DATE`        AS `RUN_DATE`,
       `c`.`NAME`            AS `NAME`,
       `s`.`NAME`            AS `SHIP_NAME`,
       `s`.`HULL_SIZE`       AS `HULL_SIZE`,
       `r`.`SHIP_ID`         AS `SHIP_ID`,
       `r`.`CREATED_AT`      AS `CREATED_AT`,
       `r`.`RUNTIME_SECONDS` AS `RUNTIME_SECONDS`
from ((`abyss`.`runs` `r` join `abyss`.`chars` `c` on ((`r`.`CHAR_ID` = `c`.`CHAR_ID`)))
         left join `abyss`.`ship_lookup` `s` on ((`r`.`SHIP_ID` = `s`.`ID`)));
        ");
        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        throw new RuntimeException("Migrating DOWN is unsupported.");
    }
}

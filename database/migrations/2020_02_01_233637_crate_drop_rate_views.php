<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class CrateDropRateViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        /** @var PDO $pdo */
        $pdo = DB::connection()->getPdo();
        $pdo->exec("
        START TRANSACTION;
drop function if exists getDropRate;
DELIMITER //
create function getDropRate(tier enum ('1', '2', '3', '4', '5'),
                            type enum ('Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma'),
                            item_id bigint) returns int
BEGIN

    DECLARE max INT;
    DECLARE actual INT;

    select COUNT(DISTINCT (RUN_ID))
    into actual
    from detailed_loot dl
             inner join runs r on dl.RUN_ID = r.ID
    where dl.ITEM_ID = item_id
      and r.TYPE = type
      and r.TIER = tier;

    select vr.cnt into max from v_actionable_runs vr where vr.TYPE = type and vr.TIER = tier;

    RETURN actual;

END;
//
DELIMITER ;
DROP VIEW IF EXISTS v_not_empty_runs;
create view v_not_empty_runs as
select `r`.`ID` AS `ID`, `r`.`TIER` AS `TIER`, `r`.`TYPE` AS `TYPE`
from `abyss`.`runs` `r`
where (exists(select 1 from `abyss`.`detailed_loot` `dl` where (`dl`.`RUN_ID` = `r`.`ID`)) and (`r`.`SURVIVED` = 1));
DROP VIEW IF EXISTS v_actionable_runs;
create view v_actionable_runs as
select count(`r`.`ID`) AS `cnt`, `vtt`.`TIER` AS `TIER`, `vtt`.`TYPE` AS `TYPE`
from (`abyss`.`v_tier_type` `vtt`
         left join `abyss`.`v_not_empty_runs` `r` on (((`r`.`TIER` = `vtt`.`TIER`) and (`r`.`TYPE` = `vtt`.`TYPE`))))
group by `vtt`.`TIER`, `vtt`.`TYPE`;
DROP VIEW IF EXISTS v_drop_rates;
create view v_drop_rates as
select ip.ITEM_ID, vr.cnt as MAX_RUNS, vr.TYPE, vr.TIER, getDropRate(vr.TIER, vr.TYPE, ip.ITEM_ID) as DROP_RATE
from item_prices ip
         join v_actionable_runs vr;
COMMIT;") or dd(print_r($pdo->errorInfo(), true));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP FUNCTION IF EXISTS getDropRate');
        DB::statement('DROP VIEW IF EXISTS v_not_empty_runs');
        DB::statement('DROP VIEW IF EXISTS v_actionable_runs');
        DB::statement('DROP VIEW IF EXISTS v_drop_rates');
        DB::statement('DROP VIEW IF EXISTS v_drop_rates');

    }
}

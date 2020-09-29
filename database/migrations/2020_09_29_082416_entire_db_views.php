<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;
    use Symfony\Component\Console\Output\ConsoleOutput;

    class EntireDbViews extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            $consoleOutput = new ConsoleOutput();
            $consoleOutput->writeln("Creating view: v_not_empty_runs");
            DB::statement("
        CREATE VIEW `v_not_empty_runs` AS
SELECT `r`.`ID` AS `ID`,
       `r`.`TIER` AS `TIER`,
       `r`.`TYPE` AS `TYPE`
FROM `runs` `r`
WHERE exists
    (SELECT 1
     FROM `detailed_loot` `dl`
     WHERE `dl`.`RUN_ID` = `r`.`ID` LIMIT 1)
  AND `r`.`SURVIVED` = 1 ;


        ");
            $consoleOutput->writeln("Creating view: v_tier_type");
            DB::statement("
CREATE VIEW `v_tier_type` AS
SELECT `tier`.`TIER` AS `TIER`,
       `type`.`TYPE` AS `TYPE`
FROM (`tier`
      JOIN `type`) ;


        ");
            $consoleOutput->writeln("Creating view: v_actionable_runs");
            DB::statement("
CREATE VIEW `v_actionable_runs` AS
SELECT count(`r`.`ID`) AS `cnt`,
       `vtt`.`TIER` AS `TIER`,
       `vtt`.`TYPE` AS `TYPE`
FROM (`v_tier_type` `vtt`
      LEFT JOIN `v_not_empty_runs` `r` on(`r`.`TIER` = `vtt`.`TIER`
                                          AND `r`.`TYPE` = `vtt`.`TYPE`))
GROUP BY `vtt`.`TIER`,
         `vtt`.`TYPE` ;

        ");
            $consoleOutput->writeln("Creating view: v_tt_run_count");
            DB::statement("
CREATE VIEW `v_tt_run_count` AS
SELECT count(`runs`.`ID`) AS `RUNS`,
       `runs`.`TIER` AS `TIER`,
       `runs`.`TYPE` AS `TYPE`
FROM `runs`
WHERE `runs`.`SHIP_ID` IS NOT NULL
GROUP BY `runs`.`TYPE`,
         `runs`.`TIER` ;


        ");
            $consoleOutput->writeln("Creating view: v_loot_details");
            DB::statement("
CREATE VIEW `v_loot_details` AS
SELECT `dl`.`ITEM_ID` AS `ITEM_ID`,
       `dl`.`RUN_ID` AS `RUN_ID`,
       `dl`.`COUNT` AS `COUNT`,
       `ip`.`NAME` AS `NAME`,
       `ip`.`DESCRIPTION` AS `DESCRIPTION`,
       `ip`.`GROUP_NAME` AS `GROUP_NAME`,
       `ip`.`PRICE_BUY` AS `PRICE_BUY`,
       `ip`.`PRICE_SELL` AS `PRICE_SELL`,
       `ip`.`PRICE_BUY` * `dl`.`COUNT` AS `BUY_PRICE_ALL`,
       `ip`.`PRICE_SELL` * `dl`.`COUNT` AS `SELL_PRICE_ALL`
FROM (`detailed_loot` `dl`
      JOIN `item_prices` `ip` on(`dl`.`ITEM_ID` = `ip`.`ITEM_ID`)) ;

        ");


            $consoleOutput->writeln("Creating function: getDropRate");
            DB::statement("
        create
    function getDropRate(tier enum ('0', '1', '2', '3', '4', '5', '6'),
                                             type enum ('Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma'),
                                             item_id bigint) returns int READS SQL DATA
BEGIN


    DECLARE actual INT;
    DECLARE increment INT;
    DECLARE previous INT;
    DECLARE cached_until TIMESTAMP;


    select MAX(di.DROPPED_COUNT) into previous from droprates_increment di
        where di.ITEM_ID = item_id
        and di.TYPE = type
        and di.TIER = tier;


    IF previous IS NULL THEN


        select COUNT(DISTINCT (RUN_ID)) into actual from detailed_loot dl inner join runs r on dl.RUN_ID = r.ID where dl.ITEM_ID = item_id and r.TYPE = type and r.TIER = tier;
        SET increment = 0;
    ELSE

        select max(dc.UPDATED_AT) into cached_until from droprates_increment dc
        where dc.ITEM_ID = item_id
        and dc.TYPE = type
        and dc.TIER = tier;
        select   max(DROPPED_COUNT) into actual from droprates_increment dc
        where dc.ITEM_ID = item_id
        and dc.TYPE = type
        and dc.TIER = tier;

        select COUNT(DISTINCT (RUN_ID)) into increment from detailed_loot dl inner join runs r on dl.RUN_ID = r.ID where dl.ITEM_ID = item_id and r.TYPE = type and r.TIER = tier and r.CREATED_AT>cached_until;

        SET actual = IFNULL(actual, 0) + IFNULL(increment, 0);

    END IF;


    insert into droprates_increment (ITEM_ID, TIER, TYPE, DROPPED_COUNT) values (item_id, tier, type, actual);
    delete from droprates_increment where  UPDATED_AT < cached_until - interval 1 day;

    RETURN actual;

END;");

            $consoleOutput->writeln("Creating view: v_drop_rates");
            DB::statement("
CREATE VIEW `v_drop_rates` AS
SELECT `ip`.`ITEM_ID` AS `ITEM_ID`,
       `vr`.`cnt` AS `MAX_RUNS`,
       `vr`.`TYPE` AS `TYPE`,
       `vr`.`TIER` AS `TIER`,
       `getDropRate`(cast(`vr`.`TIER` AS char charset utf8mb4),`vr`.`TYPE`,`ip`.`ITEM_ID`) AS `DROP_RATE`
FROM (`item_prices` `ip`
      JOIN `v_actionable_runs` `vr`);



        ");
            $consoleOutput->writeln("Creating view: v_runall");
            DB::statement("
CREATE VIEW `v_runall` AS
SELECT `r`.`ID` AS `ID`,
       `r`.`CHAR_ID` AS `CHAR_ID`,
       `r`.`PUBLIC` AS `PUBLIC`,
       `r`.`TIER` AS `TIER`,
       `r`.`TYPE` AS `TYPE`,
       `r`.`LOOT_ISK` AS `LOOT_ISK`,
       `r`.`SURVIVED` AS `SURVIVED`,
       `r`.`RUN_DATE` AS `RUN_DATE`,
       `c`.`NAME` AS `NAME`,
       `s`.`NAME` AS `SHIP_NAME`,
       `s`.`IS_CRUISER` AS `IS_CRUISER`,
       `r`.`SHIP_ID` AS `SHIP_ID`,
       `r`.`CREATED_AT` AS `CREATED_AT`,
       `r`.`RUNTIME_SECONDS` AS `RUNTIME_SECONDS`
FROM ((`runs` `r`
       JOIN `chars` `c` on(`r`.`CHAR_ID` = `c`.`CHAR_ID`))
      LEFT JOIN `ship_lookup` `s` on(`r`.`SHIP_ID` = `s`.`ID`)) ;


        ");
            $consoleOutput->writeln("Creating view: v_ship_run_count");
            DB::statement("
CREATE VIEW `v_ship_run_count` AS
SELECT count(`runs`.`ID`) AS `RUNS`,
       `runs`.`TIER` AS `TIER`,
       `runs`.`TYPE` AS `TYPE`,
       `runs`.`SHIP_ID` AS `SHIP_ID`
FROM `runs`
WHERE `runs`.`SHIP_ID` IS NOT NULL
GROUP BY `runs`.`SHIP_ID`,
         `runs`.`TYPE`,
         `runs`.`TIER` ;


        ");
            $consoleOutput->writeln("Creating view: v_ship_run_percent");
            DB::statement("
CREATE VIEW `v_ship_run_percent` AS
SELECT `src`.`TIER` AS `TIER`,
       `src`.`TYPE` AS `TYPE`,
       `src`.`SHIP_ID` AS `SHIP_ID`,
       `src`.`RUNS` AS `SHIP_RUNS`,
       `trc`.`RUNS` AS `ALL_RUNS`,
       `src`.`RUNS` / `trc`.`RUNS` * 100 AS `SHIP_PERCENT`
FROM (`v_tt_run_count` `trc`
      LEFT JOIN `v_ship_run_count` `src` on(`src`.`TIER` = `trc`.`TIER`
                                            AND `src`.`TYPE` = `trc`.`TYPE`)) ;



");
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            throw new RuntimeException("Migrating DOWN is unsupported.");
        }
    }

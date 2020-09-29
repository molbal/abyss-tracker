<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

    class UpdateProceduresForNewTiers extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
//            try {
//                DB::statement('drop function MEDIAN_FOR_FIT_TYPE_TIER;');
//                DB::statement('drop function MEDIAN_FOR_FIT_TYPE_TIER_RUNTIME;');
//                DB::statement('drop function getDropRate;');
//
//                DB::statement("
//        create
//    function getDropRate(tier enum ('0', '1', '2', '3', '4', '5', '6'),
//                                             type enum ('Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma'),
//                                             item_id bigint) returns int
//BEGIN
//
//
//    DECLARE actual INT;
//    DECLARE increment INT;
//    DECLARE previous INT;
//    DECLARE cached_until TIMESTAMP;
//
//    /* Select previous value here */
//    select MAX(di.DROPPED_COUNT) into previous from droprates_increment di
//        where di.ITEM_ID = item_id
//        and di.TYPE = type
//        and di.TIER = tier;
//
//    /* If no cache yet */
//    IF previous IS NULL THEN
//
//        /* Count number of runs */
//        select COUNT(DISTINCT (RUN_ID)) into actual from detailed_loot dl inner join runs r on dl.RUN_ID = r.ID where dl.ITEM_ID = item_id and r.TYPE = type and r.TIER = tier;
//        SET increment = 0;
//    ELSE
//        /* We have cache */
//        select max(dc.UPDATED_AT) into cached_until from droprates_increment dc
//        where dc.ITEM_ID = item_id
//        and dc.TYPE = type
//        and dc.TIER = tier;
//        select   max(DROPPED_COUNT) into actual from droprates_increment dc
//        where dc.ITEM_ID = item_id
//        and dc.TYPE = type
//        and dc.TIER = tier;
//
//
//        /* Get increment */
//        select COUNT(DISTINCT (RUN_ID)) into increment from detailed_loot dl inner join runs r on dl.RUN_ID = r.ID where dl.ITEM_ID = item_id and r.TYPE = type and r.TIER = tier and r.CREATED_AT>cached_until;
//
//        /* Add the incremented value to the previous one */
//        SET actual = IFNULL(actual, 0) + IFNULL(increment, 0);
//
//    END IF;
//
//    /* Save into cache table */
//    insert into droprates_increment (ITEM_ID, TIER, TYPE, DROPPED_COUNT) values (item_id, tier, type, actual);
//    delete from droprates_increment where  UPDATED_AT < cached_until - interval 1 day;
//
//    RETURN actual;
//
//
//        END;    ");
//
//                DB::statement("
//        create function MEDIAN_FOR_FIT_TYPE_TIER(FIT_ID bigint unsigned,
//                                      TIER enum ('0', '1', '2', '3', '4', '5', '6'),
//                                      TYPE enum ('Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma')) returns float
//BEGIN
//    set @MEDIAN = 0;
//
//    SELECT AVG(dd.LOOT_ISK) INTO @MEDIAN
//    FROM (
//             SELECT d.LOOT_ISK, @rownum := @rownum + 1 as `row_number`, @total_rows := @rownum
//             FROM runs d,
//                  (SELECT @rownum := 0) r
//             WHERE d.LOOT_ISK is NOT NULL
//               and d.FIT_ID = FIT_ID
//               and d.TIER = TIER
//               and d.TYPE = TYPE
//             ORDER BY d.LOOT_ISK
//         ) as dd
//    WHERE dd.row_number IN (FLOOR((@total_rows + 1) / 2), FLOOR((@total_rows + 2) / 2));
//
//    return @MEDIAN;
//
//        END;
//        ");
//
//                DB::statement("
//        CREATE FUNCTION MEDIAN_FOR_FIT_TYPE_TIER(FIT_ID bigint unsigned , TIER enum ('1', '2', '3', '4', '5'), TYPE enum ('Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma')  ) RETURNS float READS SQL DATA
//        BEGIN
//            set @MEDIAN = 0;
//
//            SELECT AVG(dd.LOOT_ISK) INTO @MEDIAN
//            FROM (
//            SELECT d.LOOT_ISK, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
//              FROM runs d, (SELECT @rownum:=0) r
//              WHERE d.LOOT_ISK is NOT NULL
//                and d.FIT_ID=FIT_ID and d.TIER=TIER and d.TYPE=TYPE
//              ORDER BY d.LOOT_ISK
//            ) as dd
//            WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) );
//
//            return @MEDIAN;
//
//        END ;
//        ");
//            } catch (Exception $ignored) {
//            };
        }


        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            try {
                DB::statement('drop function MEDIAN_FOR_FIT_TYPE_TIER;');
            } catch (Exception $ignored) {
            };
            try {
                DB::statement('drop function MEDIAN_FOR_FIT_TYPE_TIER_RUNTIME;');
            } catch (Exception $ignored) {
            };
            try {
                DB::statement('drop function getDropRate;');
            } catch (Exception $ignored) {
            };
        }
    }

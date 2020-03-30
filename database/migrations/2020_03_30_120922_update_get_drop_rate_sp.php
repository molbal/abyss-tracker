<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Schema;

class UpdateGetDropRateSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {

        DB::statement("
        drop function if exists getDropRate;
DELIMITER //
create function getDropRate(tier enum ('1', '2', '3', '4', '5'),
                            type enum ('Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma'),
                            item_id bigint) returns int READS SQL DATA
BEGIN


    DECLARE actual INT;
    DECLARE increment INT;
    DECLARE previous INT;
    DECLARE cached_until TIMESTAMP;

    /* Select previous value here */
    select MAX(di.DROPPED_COUNT) into previous from droprates_increment di
        where di.ITEM_ID = item_id
        and di.TYPE = type
        and di.TIER = tier;

    /* If no cache yet */
    IF previous IS NULL THEN

        /* Count number of runs */
        select COUNT(DISTINCT (RUN_ID)) into actual from detailed_loot dl inner join runs r on dl.RUN_ID = r.ID where dl.ITEM_ID = item_id and r.TYPE = type and r.TIER = tier;
        SET increment = 0;
    ELSE
        /* We have cache */
        select max(dc.UPDATED_AT) into cached_until from droprates_increment dc
        where dc.ITEM_ID = item_id
        and dc.TYPE = type
        and dc.TIER = tier;
        select   max(DROPPED_COUNT) into actual from droprates_increment dc
        where dc.ITEM_ID = item_id
        and dc.TYPE = type
        and dc.TIER = tier;


        /* Get increment */
        select COUNT(DISTINCT (RUN_ID)) into increment from detailed_loot dl inner join runs r on dl.RUN_ID = r.ID where dl.ITEM_ID = item_id and r.TYPE = type and r.TIER = tier and r.CREATED_AT>cached_until;

        /* Add the incremented value to the previous one */
        SET actual = IFNULL(actual, 0) + IFNULL(increment, 0);

    END IF;

    /* Save into cache table */
    insert into droprates_increment (ITEM_ID, TIER, TYPE, DROPPED_COUNT) values (item_id, tier, type, actual);
    delete from droprates_increment where  UPDATED_AT < cached_until - interval 1 day;

    RETURN actual;

END;
//
DELIMITER ;

        ");
        }
        catch (Exception $e) {
            Log::warning("Error during migration (up): ". $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {

            DB::statement("
        drop function if exists getDropRate;
DELIMITER //
create function getDropRate(tier enum ('1', '2', '3', '4', '5'),
                            type enum ('Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma'),
                            item_id bigint) returns int READS SQL DATA
BEGIN


#     DECLARE max INT;
    DECLARE actual INT;

    select COUNT(DISTINCT (RUN_ID))
    into actual
    from detailed_loot dl
             inner join runs r on dl.RUN_ID = r.ID
    where dl.ITEM_ID = item_id
      and r.TYPE = type
      and r.TIER = tier;

#     select vr.cnt into max from v_actionable_runs vr where vr.TYPE = type and vr.TIER = tier;

    RETURN actual;

END;
//
DELIMITER ;

        ");
    }
catch (Exception $e) {
Log::warning("Error during migration (down): ". $e->getMessage());
}
    }
}

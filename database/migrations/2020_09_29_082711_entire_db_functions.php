<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;
    use Symfony\Component\Console\Output\ConsoleOutput;

    class EntireDbFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $consoleOutput = new ConsoleOutput();

        $consoleOutput->writeln("Creating function: MEDIAN_FOR_FIT_TYPE_TIER");
        DB::statement("

create
    function MEDIAN_FOR_FIT_TYPE_TIER(FIT_ID bigint unsigned,
                                                          TIER enum ('0', '1', '2', '3', '4', '5', '6'),
                                                          TYPE enum ('Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma')) returns float READS SQL DATA
BEGIN
    set @MEDIAN = 0;

    SELECT AVG(dd.LOOT_ISK) INTO @MEDIAN
    FROM (
             SELECT d.LOOT_ISK, @rownum := @rownum + 1 as `row_number`, @total_rows := @rownum
             FROM runs d,
                  (SELECT @rownum := 0) r
             WHERE d.LOOT_ISK is NOT NULL
               and d.FIT_ID = FIT_ID
               and d.TIER = TIER
               and d.TYPE = TYPE
             ORDER BY d.LOOT_ISK
         ) as dd
    WHERE dd.row_number IN (FLOOR((@total_rows + 1) / 2), FLOOR((@total_rows + 2) / 2));

    return @MEDIAN;

END;
        ");
        $consoleOutput->writeln("Creating function: MEDIAN_FOR_FIT_TYPE_TIER_RUNTIME");
        DB::statement("
create
   function MEDIAN_FOR_FIT_TYPE_TIER_RUNTIME(FIT_ID bigint unsigned,
                                                                  TIER enum ('0', '1', '2', '3', '4', '5', '6'),
                                                                  TYPE enum ('Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma')) returns float READS SQL DATA
BEGIN
            set @MEDIAN = 0;

            SELECT AVG(dd.RUNTIME_SECONDS) INTO @MEDIAN
            FROM (
            SELECT d.RUNTIME_SECONDS, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
              FROM runs d, (SELECT @rownum:=0) r
              WHERE d.RUNTIME_SECONDS is NOT NULL
                and d.FIT_ID=FIT_ID and d.TIER=TIER and d.TYPE=TYPE
              ORDER BY d.RUNTIME_SECONDS
            ) as dd
            WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) );

            return @MEDIAN;

        END;


        ");
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

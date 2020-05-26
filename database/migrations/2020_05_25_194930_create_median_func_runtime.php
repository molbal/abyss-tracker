<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Support\Facades\DB;

    class CreateMedianFuncRuntime extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            DB::statement("
        DROP FUNCTION IF EXISTS MEDIAN_FOR_FIT_TYPE_TIER_RUNTIME;

        DELIMITER //
        CREATE FUNCTION MEDIAN_FOR_FIT_TYPE_TIER_RUNTIME(FIT_ID bigint unsigned , TIER enum ('1', '2', '3', '4', '5'), TYPE enum ('Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma')  ) RETURNS float READS SQL DATA
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

        END
        //
        DELIMITER ;
        ");
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            DB::statement("
            DROP FUNCTION IF EXISTS MEDIAN_FOR_FIT_TYPE_TIER_RUNTIME;
        ");
        }
    }

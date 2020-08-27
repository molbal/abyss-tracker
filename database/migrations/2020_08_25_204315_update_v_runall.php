<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class UpdateVRunall extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        DROP VIEW v_runall;
CREATE VIEW v_runall AS
select `r`.`ID`         AS `ID`,
       `r`.`CHAR_ID`    AS `CHAR_ID`,
       `r`.`PUBLIC`     AS `PUBLIC`,
       `r`.`TIER`       AS `TIER`,
       `r`.`TYPE`       AS `TYPE`,
       `r`.`LOOT_ISK`   AS `LOOT_ISK`,
       `r`.`SURVIVED`   AS `SURVIVED`,
       `r`.`RUN_DATE`   AS `RUN_DATE`,
       `c`.`NAME`       AS `NAME`,
       `s`.`NAME`       AS `SHIP_NAME`,
       `s`.`IS_CRUISER` AS `IS_CRUISER`,
       `r`.`SHIP_ID`    AS `SHIP_ID`,
       `r`.`CREATED_AT` AS `CREATED_AT`,
       `r`.`RUNTIME_SECONDS` AS `RUNTIME_SECONDS`
from ((`abyss`.`runs` `r` join `abyss`.`chars` `c` on ((`r`.`CHAR_ID` = `c`.`CHAR_ID`)))
         left join `abyss`.`ship_lookup` `s` on ((`r`.`SHIP_ID` = `s`.`ID`)));

');
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

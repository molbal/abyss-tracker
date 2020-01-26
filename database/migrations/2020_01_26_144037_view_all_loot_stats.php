<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class ViewAllLootStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW v_all_loot_stats AS
        select
(select count(ID) from runs where 0<LOOT_ISK && LOOT_ISK<=2500000 ) AS \"A\",
(select count(ID) from runs where 2500000<LOOT_ISK && LOOT_ISK<=5000000 ) AS \"B\",
(select count(ID) from runs where 5000000<LOOT_ISK && LOOT_ISK<=10000000 ) AS \"C\",
(select count(ID) from runs where 10000000<LOOT_ISK && LOOT_ISK<=15000000 ) AS \"D\",
(select count(ID) from runs where 15000000<LOOT_ISK && LOOT_ISK<=25000000 ) AS \"E\",
(select count(ID) from runs where 25000000<LOOT_ISK && LOOT_ISK<=35000000 ) AS \"F\",
(select count(ID) from runs where 35000000<LOOT_ISK && LOOT_ISK<=50000000 ) AS \"G\",
(select count(ID) from runs where 50000000<LOOT_ISK && LOOT_ISK<=65000000 ) AS \"H\",
(select count(ID) from runs where 65000000<LOOT_ISK && LOOT_ISK<=100000000 ) AS \"I\",
(select count(ID) from runs where 100000000<LOOT_ISK ) AS \"J\"
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS v_all_loot_stats');
    }
}

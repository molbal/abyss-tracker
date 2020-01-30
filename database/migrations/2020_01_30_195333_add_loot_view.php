<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class AddLootView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS v_loot_details');
        DB::statement("
        CREATE VIEW v_loot_details AS
        select
    dl.ITEM_ID,
       dl.RUN_ID,
       dl.COUNT,
       ip.NAME,
       ip.DESCRIPTION,
       ip.GROUP_NAME,
       ip.PRICE_BUY,
       ip.PRICE_SELL,
       ip.PRICE_BUY*dl.COUNT as BUY_PRICE_ALL,
       ip.PRICE_SELL*dl.COUNT  as SELL_PRICE_ALL
from detailed_loot dl  inner join item_prices ip on dl.ITEM_ID = ip.ITEM_ID
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS v_loot_details');
    }
}

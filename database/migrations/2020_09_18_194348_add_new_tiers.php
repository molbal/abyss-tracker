<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class AddNewTiers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("alter table runs modify TIER enum('1', '2', '3', '4', '5', '6', '0') not null;");
        DB::statement("alter table droprates_cache modify TIER enum('1', '2', '3', '4', '5', '6', '0') not null;");
        DB::statement("alter table droprates_increment modify TIER enum('1', '2', '3', '4', '5', '6', '0') not null;");
        DB::statement("alter table filament_types modify TIER enum('1', '2', '3', '4', '5', '6', '0') not null;");
        DB::statement("alter table video_tutorials modify tier enum('1', '2', '3', '4', '5', '6', '0');");
        DB::table("tier")->insert([['TIER' => 0], ["TIER" => 6]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("alter table runs modify TIER enum('1', '2', '3', '4', '5') not null;");
        DB::statement("alter table droprates_cache modify TIER enum('1', '2', '3', '4', '5') not null;");
        DB::statement("alter table droprates_increment modify TIER enum('1', '2', '3', '4', '5') not null;");
        DB::statement("alter table filament_types modify TIER enum('1', '2', '3', '4', '5') not null;");
        DB::statement("alter table video_tutorials modify tier enum('1', '2', '3', '4', '5') not null;");
        DB::table("tier")->whereIn("TIER", ['0','6'])->delete();
    }
}

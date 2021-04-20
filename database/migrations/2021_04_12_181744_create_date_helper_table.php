<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class CreateDateHelperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_helper', function (Blueprint $table) {
            $table->date('day')->primary();
        });

        $first = \Carbon\Carbon::parse(DB::table('runs')->min('RUN_DATE'))->setMonth(1)->setDay(1);

        for ($i=0; $i<356*30; $i++) {
            DB::table('date_helper')->insert(['day' => $first]);
            $first->addDay();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('date_helper');
    }
}

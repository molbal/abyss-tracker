<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendRunsInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("runs",function (Blueprint $t) {
            $t->bigInteger("ship_id")->nullable()->index();
            $t->enum("death_reason", [
                'TIMEOUT',
                'TANK_FAILED',
                'CONNECTION_DROP',
                'PILOTING_FAIL',
            ]);
        });
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

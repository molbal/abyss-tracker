<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDroneBandwidthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drone_bandwidth', function (Blueprint $table) {
            $table->unsignedBigInteger("ID")->primary()->comment("ITEM ID of a ship or drone");
            $table->integer("VALUE")->comment("Max drone bandwidth for ships, used drone bandwidth for drones");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drone_bandwidth');
    }
}

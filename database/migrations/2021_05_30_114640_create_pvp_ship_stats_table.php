<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePvpShipStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvp_ship_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('killmail_id');
            $table->json('stats')->nullable(true);
            $table->foreign('killmail_id')->references('killmail_id')->on('pvp_victims');
            $table->string('error_text', 128)->nullable(true);
            $table->string('eft', 2048);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pvp_ship_stats');
    }
}

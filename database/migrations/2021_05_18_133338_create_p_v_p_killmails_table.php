<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePVPKillmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvp_killmails', function (Blueprint $table) {
            $table->unsignedBigInteger('kill_id')->primary();

            $table->unsignedBigInteger('winner_char_id');
            $table->string('winner_char_name', 128);

            $table->unsignedBigInteger('winner_corp_id');
            $table->string('winner_corp_name', 128);

            $table->unsignedBigInteger('winner_ship_id');
            $table->string('winner_ship_name', 128);

            $table->unsignedBigInteger('winner_ship_type_id');
            $table->string('winner_ship_type_name', 128);

            $table->unsignedBigInteger('winner_ship_id');
            $table->string('winner_ship_name', 128);

            $table->unsignedBigInteger('loser_char_id');
            $table->string('loser_char_name', 128);

            $table->unsignedBigInteger('loser_corp_id');
            $table->string('loser_corp_name', 128);

            $table->unsignedBigInteger('loser_ship_id');
            $table->string('loser_ship_name', 128);

            $table->unsignedBigInteger('loser_ship_type_id');
            $table->string('loser_ship_type_name', 128);

            $table->unsignedBigInteger('loser_ship_id');
            $table->string('loser_ship_name', 128);

            $table->json('raw_killmail');
            $table->unsignedBigInteger('killmail_price');


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
        Schema::dropIfExists('pvp_killmails');
    }
}

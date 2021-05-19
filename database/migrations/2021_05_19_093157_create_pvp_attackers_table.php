<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePvpAttackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvp_characters', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name', 128);
        });

        Schema::create('pvp_corporations', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name', 128);
        });

        Schema::create('pvp_alliances', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name', 128);
        });

        Schema::create('pvp_group_id_lookup', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name',128);
        });

        Schema::create('pvp_type_id_lookup', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('group_id')->index();
            $table->string('name',128);

            $table->foreign('group_id')->references('id')->on('pvp_group_id_lookup');
        });



        Schema::create('pvp_victims', function (Blueprint $table) {
            $table->unsignedBigInteger('killmail_id')->primary();

            $table->unsignedBigInteger('character_id');
            $table->unsignedBigInteger('corporation_id');
            $table->unsignedBigInteger('alliance_id')->nullable(true);
            $table->unsignedBigInteger('damage_taken');
            $table->unsignedBigInteger('ship_type_id');

            $table->unsignedBigInteger('pvp_event_id');

            $table->json('littlekill');
            $table->json('fullkill');

            $table->timestamps();

            $table->foreign('character_id')->references('id')->on('pvp_characters');
            $table->foreign('corporation_id')->references('id')->on('pvp_corporations');
            $table->foreign('pvp_event_id')->references('id')->on('pvp_events');
        });

        Schema::create('pvp_attackers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('character_id');
            $table->unsignedBigInteger('corporation_id');
            $table->unsignedBigInteger('alliance_id')->nullable(true);
            $table->unsignedBigInteger('damage_done');
            $table->boolean('final_blow');
            $table->float('security_status');
            $table->unsignedBigInteger('ship_type_id');
            $table->unsignedBigInteger('killmail_id');

            $table->timestamps();

            $table->foreign('killmail_id')->references('killmail_id')->on('pvp_victims');
            $table->foreign('character_id')->references('id')->on('pvp_characters');
            $table->foreign('corporation_id')->references('id')->on('pvp_corporations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('pvp_type_id_lookup');
        Schema::dropIfExists('pvp_group_id_lookup');
        Schema::dropIfExists('pvp_alliances');
        Schema::dropIfExists('pvp_victims');
        Schema::dropIfExists('pvp_attackers');
        Schema::dropIfExists('pvp_corporations');
        Schema::dropIfExists('pvp_characters');
        Schema::enableForeignKeyConstraints();

    }
}

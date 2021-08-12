<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConduitLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conduit_log', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->unsignedBigInteger('char_id')->nullable(true);
            $blueprint->string('endpoint', 128)->nullable(true);
            $blueprint->dateTime('requested_at')->nullable(true);
            $blueprint->float('execution_time')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conduit_log');
    }
}

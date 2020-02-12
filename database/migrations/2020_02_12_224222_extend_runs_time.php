<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendRunsTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("runs", function(Blueprint $t) {
            $t->unsignedInteger("RUNTIME_SECONDS")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table("runs", function(Blueprint $t) {
            $t->removeColumn("RUNTIME_SECONDS");
        });
    }
}

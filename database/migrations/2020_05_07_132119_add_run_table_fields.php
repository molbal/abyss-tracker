<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRunTableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("runs", function (Blueprint $table) {
            $table->unsignedBigInteger("FIT_ID")->nullable();
            $table->unsignedTinyInteger('IS_BONUS')->nullable();
        });

        Schema::table("fits", function (Blueprint $table) {
            $table->string("VIDEO_LINK",256)->nullable();
            $table->enum('PRIVACY', ['public', 'incognito', 'private'])->nullable();
            $table->string("FFH", 32)->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("runs", function (Blueprint $table) {
            $table->dropColumn(['FIT_ID', 'IS_BONUS']);
        });

        Schema::table("fits", function (Blueprint $table) {
            $table->dropColumn(['VIDEO_LINK', 'PRIVACY']);
        });
    }
}

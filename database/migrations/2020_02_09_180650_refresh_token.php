<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefreshToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("chars", function(Blueprint $t) {
            $t->string("REFRESH_TOKEN",1000)->comment("Eve OAuth2 Refresh Token");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table("chars", function(Blueprint $t) {
            $t->removeColumn("REFRESH_TOKEN");
        });
    }
}

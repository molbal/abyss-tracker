<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Privacy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privacy', function (Blueprint $table) {
            $table->bigInteger("CHAR_ID");
            $table->foreign("CHAR_ID")->references("CHAR_ID")->on("chars");
            $table->string("PANEL", 32);
            $table->enum("DISPLAY", ["private", "public"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('privacy');
    }
}

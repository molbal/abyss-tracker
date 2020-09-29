<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentCreatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_creators', function (Blueprint $table) {
            $table->id();
            $table->string("NAME", 128);
            $table->unsignedBigInteger("CHAR_ID")->nullable();
            $table->string("DISCORD", 128)->nullable();
            $table->string("YOUTUBE", 128)->nullable();
            $table->string("TWITTER", 128)->nullable();
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
        Schema::dropIfExists('content_creators');
    }
}

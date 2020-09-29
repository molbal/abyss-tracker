<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorialVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorial_votes', function (Blueprint $table) {
            $table->unsignedBigInteger("video_id");
            $table->bigInteger("char_id");
            $table->primary(['video_id', 'char_id']);

            $table->enum("opinion", ['approves', 'disapproves']);

            $table->index(["video_id"]);
            $table->index(["video_id", "opinion"]);
            $table->foreign("video_id")->references("id")->on("video_tutorials");
            $table->foreign("char_id")->references("CHAR_ID")->on("chars");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutorial_votes');
    }
}

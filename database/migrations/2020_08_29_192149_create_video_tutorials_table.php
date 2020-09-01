<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoTutorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_tutorials', function (Blueprint $table) {
            $table->id();
            $table->string("youtube_id", 32);
            $table->string("name", 128);
            $table->unsignedBigInteger("content_creator_id")->nullable(false);
            $table->json("video_bookmarks");
            $table->enum("tier", ['1','2','3','4','5'])->nullable(true);
            $table->enum("type", ['Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma'])->nullable(true);
            $table->string("description", 1024);
            $table->timestamps();
            $table->foreign(["content_creator_id"])->references('id')->on("content_creators");
        });

        Schema::create('video_tutorial_fits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("video_tutorial_id")->nullable(false);
            $table->unsignedBigInteger("fit_id")->nullable(false);
            $table->timestamps();

            $table->foreign(["video_tutorial_id"])->references('id')->on("video_tutorials");
            $table->foreign(["fit_id"])->references('ID')->on("fits");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_tutorial_fits');
        Schema::dropIfExists('video_tutorials');
    }
}

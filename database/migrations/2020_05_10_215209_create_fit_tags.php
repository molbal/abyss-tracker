<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFitTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fit_tags', function (Blueprint $table) {
            $table->unsignedBigInteger("FIT_ID");
            $table->string("TAG_NAME", "24");
            $table->tinyInteger("TAG_VALUE");

            $table->primary(["FIT_ID", "TAG_NAME"]);
            $table->foreign("FIT_ID")->references("ID")->on("fits");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fit_tags');
    }
}

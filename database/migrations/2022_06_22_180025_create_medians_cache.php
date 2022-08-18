<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediansCache extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medians_cache', function (Blueprint $table) {
            $table->id();
            $table->enum('tier',[0,1,2,3,4,5,6]);
            $table->string('type', 16);
            $table->date('day');
            $table->unsignedSmallInteger('span');
            $table->enum('hull_size', ['frigate', 'destroyer', 'cruiser']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medians_cache');
    }
}

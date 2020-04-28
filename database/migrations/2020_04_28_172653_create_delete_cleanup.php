<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeleteCleanup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delete_cleanup', function (Blueprint $table) {
            $table->unsignedBigInteger("ITEM_ID");
            $table->enum("TIER", ['1', '2', '3', '4', '5']);
            $table->enum("TYPE", ['Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma']);
            $table->integer("DELETES_SUM");

            $table->index(["ITEM_ID", "TIER", "TYPE"]);
            $table->foreign("ITEM_ID")->references("ITEM_ID")->on("ITEM_PRICES");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delete_cleanup');
    }
}

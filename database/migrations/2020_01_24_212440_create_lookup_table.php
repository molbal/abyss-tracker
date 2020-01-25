<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLookupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("chars", function (Blueprint $t) {
            $t->bigInteger("CHAR_ID")->primary();
            $t->string("NAME", 128);
        });

        Schema::create("runs", function (Blueprint $t) {
           $t->increments("ID");
           $t->bigInteger("CHAR_ID");
           $t->boolean("PUBLIC");
           $t->enum("TIER", ['1','2','3','4','5']);
           $t->enum("TYPE", ['Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma']);
           $t->integer("LOOT_ISK");
           $t->boolean("SURVIVED")->default(true);
           $t->date('RUN_DATE');

           $t->index(["CHAR_ID"]);
           $t->index(['RUN_DATE']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("chars");
        Schema::dropIfExists("runs");
    }
}

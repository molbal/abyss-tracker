<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

class FitsTableAddRootIdUpToDateRevision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fits', function (Blueprint $table) {
            $table->unsignedBigInteger("ROOT_ID")->nullable(true)->index();
            $table->unsignedInteger("REVISION_NUMBER")->default('0');
            $table->enum('LAST_PATCH', ['untested', 'works', 'deprecated'])->default('untested');
        });
        DB::unprepared("update fits set ROOT_ID=ID");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fits', function (Blueprint $table) {
            $table->dropColumn(['ROOT_ID','REVISION_NUMBER','LAST_PATCH']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Schema;

class AddRunsFitIdIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            DB::statement("create index runs_fit_id on runs (FIT_ID); ");
        }
        catch (Exception $e) {
            Log::warning("Could not add index on runs.FIT_ID: ".$e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            @DB::statement("drop index runs_fit_id;");
    }
}

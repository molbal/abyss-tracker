<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;
    use Symfony\Component\Console\Output\ConsoleOutput;

    class ShipsLookupEnableDestroyers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $consoleOutput = new ConsoleOutput();
        DB::beginTransaction();
        $consoleOutput->writeln("Adding new column: ship_lookup.HULL_SIZE");
        DB::unprepared("alter table ship_lookup add HULL_SIZE enum('frigate', 'destroyer', 'cruiser') default NULL null;");

        $consoleOutput->writeln("Filling column for cruiser size ships");
        DB::table('ship_lookup')->where('IS_CRUISER',1)->update(['HULL_SIZE' => 'cruiser']);
        $consoleOutput->writeln("Filling column for destroyer size ships");
        DB::table('ship_lookup')->where('IS_CRUISER',0)->update(['HULL_SIZE' => 'frigate']);
        $consoleOutput->writeln("Dropping legacy IS_CRUISER column");
        DB::unprepared("alter table ship_lookup drop column IS_CRUISER;");
        $consoleOutput->writeln("Adding destroyers");
        DB::table('ship_lookup')->insert([
            ["NAME" => 'Catalyst', 'GROUP' => 'Destroyer', 'ID' => 16240, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Algos', 'GROUP' => 'Destroyer', 'ID' => 32872, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Thrasher', 'GROUP' => 'Destroyer', 'ID' => 16242, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Talwar', 'GROUP' => 'Destroyer', 'ID' => 32878, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Coercer', 'GROUP' => 'Destroyer', 'ID' => 16236, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Dragoon', 'GROUP' => 'Destroyer', 'ID' => 32874, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Cormorant', 'GROUP' => 'Destroyer', 'ID' => 16238, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Corax', 'GROUP' => 'Destroyer', 'ID' => 32876, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Kikimora', 'GROUP' => 'Destroyer', 'ID' => 49710, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Sunesis', 'GROUP' => 'Destroyer', 'ID' => 42685, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Draugur', 'GROUP' => 'Command Destroyer', 'ID' => 52254, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Pontifex', 'GROUP' => 'Command Destroyer', 'ID' => 37481, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Stork', 'GROUP' => 'Command Destroyer', 'ID' => 37482, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Magus', 'GROUP' => 'Command Destroyer', 'ID' => 37483, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Bifrost', 'GROUP' => 'Command Destroyer', 'ID' => 37480, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Sabre', 'GROUP' => 'Interdictor', 'ID' => 22456, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Eris', 'GROUP' => 'Interdictor', 'ID' => 22460, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Flycatcher', 'GROUP' => 'Interdictor', 'ID' => 22464, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Heretic', 'GROUP' => 'Interdictor', 'ID' => 22452, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Confessor', 'GROUP' => 'Tactical destroyer', 'ID' => 34317, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Jackdaw', 'GROUP' => 'Tactical destroyer', 'ID' => 34828, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Hecate', 'GROUP' => 'Tactical destroyer', 'ID' => 35683, 'HULL_SIZE' => 'destroyer'],
            ["NAME" => 'Svipul', 'GROUP' => 'Tactical destroyer', 'ID' => 34562, 'HULL_SIZE' => 'destroyer'],
        ]);

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        throw new RuntimeException("Migrating DOWN is unsupported.");
    }
}

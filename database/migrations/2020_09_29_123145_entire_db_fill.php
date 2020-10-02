<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
    use Symfony\Component\Console\Output\ConsoleOutput;

    class EntireDbFill extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            //  Fill dump invTypes20200511
            $consoleOutput = new ConsoleOutput();
            try {

                $lines = collect(explode('INSERT INTO ',Storage::disk('dumps')->get('invTypes20200511.sql')));
                $lines->each(function ($line, $key) use ($consoleOutput) {
                    if ($line == "") return;
                    $consoleOutput->writeln("Executing line (".strlen($line)." chars length)");
                    DB::unprepared('INSERT INTO '.$line);
                });
                $consoleOutput->writeln("Dumps table complete.");
            }
            catch (Exception $e) {
                $consoleOutput->writeln("Dumps table error: ".$e->getMessage()."");
                DB::rollBack();
            }

            DB::beginTransaction();

            DB::unprepared("INSERT INTO `tier` (`TIER`) VALUES (1),(2),(3),(4),(5),(0),(6);");
            $consoleOutput->writeln("Tiers added");
            DB::unprepared("INSERT INTO `type` (`TYPE`) VALUES ('Electrical'),('Dark'),('Exotic'),('Firestorm'),('Gamma');");
            $consoleOutput->writeln("Types added");

            DB::unprepared("TRUNCATE filament_types");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('0', 'Electrical', 56131);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('0', 'Dark', 56132);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('0', 'Exotic', 56133);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('0', 'Firestorm', 56134);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('0', 'Gamma', 056136);");

            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('1', 'Electrical', 47765);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('1', 'Dark', 47762);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('1', 'Exotic', 47761);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('1', 'Firestorm', 47763);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('1', 'Gamma', 47764);");

            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('2', 'Electrical', 47904);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('2', 'Dark', 47892);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('2', 'Exotic', 47888);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('2', 'Firestorm', 47896);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('2', 'Gamma', 47900);");

            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('3', 'Electrical', 47905);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('3', 'Dark', 47893);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('3', 'Exotic', 47889);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('3', 'Firestorm', 47897);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('3', 'Gamma', 47901);");

            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('4', 'Electrical', 47906);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('4', 'Dark', 47894);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('4', 'Exotic', 47890);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('4', 'Firestorm', 47898);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('4', 'Gamma', 47902);");

            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('5', 'Electrical', 47907);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('5', 'Dark', 47895);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('5', 'Exotic', 47891);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('5', 'Firestorm', 47899);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('5', 'Gamma', 47903);");

            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('6', 'Electrical', 56139);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('6', 'Dark', 56140);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('6', 'Exotic', 56141);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('6', 'Firestorm', 56142);");
            DB::unprepared("INSERT INTO filament_types (TIER, TYPE, ITEM_ID) VALUES ('6', 'Gamma', 56143);");
            $consoleOutput->writeln("T0-6 filaments added");

            DB::commit();
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            throw new RuntimeException("Migrating DOWN is unsupported.");
        }
    }

<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

    class FilamentTypes extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('filament_types', function (Blueprint $t) {
                $t->enum("TIER", ['1', '2', '3', '4', '5']);
                $t->enum("TYPE", ['Electrical', 'Dark', 'Exotic', 'Firestorm', 'Gamma']);
                $t->unsignedBigInteger("ITEM_ID");
                $t->primary(["TIER", "TYPE"]);
            });

            DB::table("filament_types")->insert([
                ["TYPE" => 'Electrical', 'TIER' => 1, "ITEM_ID" => 47765],
                ["TYPE" => 'Dark', 'TIER' => 1, "ITEM_ID" => 47762],
                ["TYPE" => 'Exotic', 'TIER' => 1, "ITEM_ID" => 47761],
                ["TYPE" => 'Firestorm', 'TIER' => 1, "ITEM_ID" => 47763],
                ["TYPE" => 'Gamma', 'TIER' => 1, "ITEM_ID" => 47764],
                ["TYPE" => 'Electrical', 'TIER' => 2, "ITEM_ID" => 47904],
                ["TYPE" => 'Dark', 'TIER' => 2, "ITEM_ID" => 47892],
                ["TYPE" => 'Exotic', 'TIER' => 2, "ITEM_ID" => 47888],
                ["TYPE" => 'Firestorm', 'TIER' => 2, "ITEM_ID" => 47896],
                ["TYPE" => 'Gamma', 'TIER' => 2, "ITEM_ID" => 47900],
                ["TYPE" => 'Electrical', 'TIER' => 3, "ITEM_ID" => 47905],
                ["TYPE" => 'Dark', 'TIER' => 3, "ITEM_ID" => 47893],
                ["TYPE" => 'Exotic', 'TIER' => 3, "ITEM_ID" => 47889],
                ["TYPE" => 'Firestorm', 'TIER' => 3, "ITEM_ID" => 47897],
                ["TYPE" => 'Gamma', 'TIER' => 3, "ITEM_ID" => 47901],
                ["TYPE" => 'Electrical', 'TIER' => 4, "ITEM_ID" => 47906],
                ["TYPE" => 'Dark', 'TIER' => 4, "ITEM_ID" => 47894],
                ["TYPE" => 'Exotic', 'TIER' => 4, "ITEM_ID" => 47890],
                ["TYPE" => 'Firestorm', 'TIER' => 4, "ITEM_ID" => 47898],
                ["TYPE" => 'Gamma', 'TIER' => 4, "ITEM_ID" => 47902],
                ["TYPE" => 'Electrical', 'TIER' => 5, "ITEM_ID" => 47907],
                ["TYPE" => 'Dark', 'TIER' => 5, "ITEM_ID" => 47895],
                ["TYPE" => 'Exotic', 'TIER' => 5, "ITEM_ID" => 47891],
                ["TYPE" => 'Firestorm', 'TIER' => 5, "ITEM_ID" => 47899],
                ["TYPE" => 'Gamma', 'TIER' => 5, "ITEM_ID" => 47903]

            ]);
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists('filament_types');
        }
    }

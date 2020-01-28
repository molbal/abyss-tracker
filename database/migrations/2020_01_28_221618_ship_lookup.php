<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

    class ShipLookup extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('ship_lookup', function (Blueprint $table) {
                $table->unsignedBigInteger('ID')->primary();
                $table->string("NAME", 128);
                $table->string("GROUP", 32);
                $table->boolean("IS_CRUISER");
            });

            DB::table("ship_lookup")
                ->insert([
                    ["ID" => 2836, "NAME" => "Adrestia", "GROUP" => "Heavy Assault Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 11188, "NAME" => "Anathema", "GROUP" => "Covert Ops", "IS_CRUISER" => 0],
                    ["ID" => 628, "NAME" => "Arbitrator", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 11202, "NAME" => "Ares", "GROUP" => "Interceptor", "IS_CRUISER" => 0],
                    ["ID" => 17922, "NAME" => "Ashimmu", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 33468, "NAME" => "Astero", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 608, "NAME" => "Atron", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 625, "NAME" => "Augoror", "GROUP" => "Cruiser", "IS_CRUISER" => 0],
                    ["ID" => 29337, "NAME" => "Augoror Navy Issue", "GROUP" => "Cruiser", "IS_CRUISER" => 0],
                    ["ID" => 582, "NAME" => "Bantam", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 630, "NAME" => "Bellicose", "GROUP" => "Cruiser", "IS_CRUISER" => 0],
                    ["ID" => 632, "NAME" => "Blackbird", "GROUP" => "Cruiser", "IS_CRUISER" => 0],
                    ["ID" => 598, "NAME" => "Breacher", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 12013, "NAME" => "Broadsword", "GROUP" => "Heavy Interdiction Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 599, "NAME" => "Burst", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11192, "NAME" => "Buzzard", "GROUP" => "Covert Ops", "IS_CRUISER" => 0],
                    ["ID" => 42246, "NAME" => "Caedes", "GROUP" => "Covert Ops", "IS_CRUISER" => 0],
                    ["ID" => 17619, "NAME" => "Caldari Navy Hookbill", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 32788, "NAME" => "Cambion", "GROUP" => "Assault Frigate", "IS_CRUISER" => 0],
                    ["ID" => 621, "NAME" => "Caracal", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 17634, "NAME" => "Caracal Navy Issue", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 633, "NAME" => "Celestis", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 11993, "NAME" => "Cerberus", "GROUP" => "Heavy Assault Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 11182, "NAME" => "Cheetah", "GROUP" => "Covert Ops", "IS_CRUISER" => 0],
                    ["ID" => 33397, "NAME" => "Chremoas", "GROUP" => "Covert Ops", "IS_CRUISER" => 0],
                    ["ID" => 11196, "NAME" => "Claw", "GROUP" => "Interceptor", "IS_CRUISER" => 0],
                    ["ID" => 583, "NAME" => "Condor", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11176, "NAME" => "Crow", "GROUP" => "Interceptor", "IS_CRUISER" => 0],
                    ["ID" => 2161, "NAME" => "Crucifier", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 37453, "NAME" => "Crucifier Navy Issue", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 17926, "NAME" => "Cruor", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11184, "NAME" => "Crusader", "GROUP" => "Interceptor", "IS_CRUISER" => 0],
                    ["ID" => 17720, "NAME" => "Cynabal", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 47269, "NAME" => "Damavik", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 17928, "NAME" => "Daredevil", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 12023, "NAME" => "Deimos", "GROUP" => "Heavy Assault Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 12017, "NAME" => "Devoter", "GROUP" => "Heavy Interdiction Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 17932, "NAME" => "Dramiel", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 12011, "NAME" => "Eagle", "GROUP" => "Heavy Assault Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 3532, "NAME" => "Echelon", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 37135, "NAME" => "Endurance", "GROUP" => "Expedition Frigate", "IS_CRUISER" => 0],
                    ["ID" => 12044, "NAME" => "Enyo", "GROUP" => "Assault Frigate", "IS_CRUISER" => 0],
                    ["ID" => 589, "NAME" => "Executioner", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 634, "NAME" => "Exequror", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 29344, "NAME" => "Exequror Navy Issue", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 17841, "NAME" => "Federation Navy Comet", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 35781, "NAME" => "Fiend", "GROUP" => "Heavy Interdiction Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 32207, "NAME" => "Freki", "GROUP" => "Assault Frigate", "IS_CRUISER" => 0],
                    ["ID" => 33816, "NAME" => "Garmur", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 17715, "NAME" => "Gila", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 11940, "NAME" => "Gold Magnate", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 584, "NAME" => "Griffin", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 37455, "NAME" => "Griffin Navy Issue", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11011, "NAME" => "Guardian-Vexor", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 11381, "NAME" => "Harpy", "GROUP" => "Assault Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11379, "NAME" => "Hawk", "GROUP" => "Assault Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11172, "NAME" => "Helios", "GROUP" => "Covert Ops", "IS_CRUISER" => 0],
                    ["ID" => 605, "NAME" => "Heron", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 12034, "NAME" => "Hound", "GROUP" => "Stealth Bomber", "IS_CRUISER" => 0],
                    ["ID" => 11387, "NAME" => "Ikitursa", "GROUP" => "Heavy Assault Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 52252, "NAME" => "Hyena", "GROUP" => "Electronic Attack Ship", "IS_CRUISER" => 0],
                    ["ID" => 607, "NAME" => "Imicus", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 35779, "NAME" => "Imp", "GROUP" => "Interceptor", "IS_CRUISER" => 0],
                    ["ID" => 17703, "NAME" => "Imperial Navy Slicer", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 594, "NAME" => "Incursus", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 590, "NAME" => "Inquisitor", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 12042, "NAME" => "Ishkur", "GROUP" => "Assault Frigate", "IS_CRUISER" => 0],
                    ["ID" => 12005, "NAME" => "Ishtar", "GROUP" => "Heavy Assault Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 11400, "NAME" => "Jaguar", "GROUP" => "Assault Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11174, "NAME" => "Keres", "GROUP" => "Electronic Attack Ship", "IS_CRUISER" => 0],
                    ["ID" => 602, "NAME" => "Kestrel", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11194, "NAME" => "Kitsune", "GROUP" => "Electronic Attack Ship", "IS_CRUISER" => 0],
                    ["ID" => 29248, "NAME" => "Magnate", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11186, "NAME" => "Malediction", "GROUP" => "Interceptor", "IS_CRUISER" => 0],
                    ["ID" => 3516, "NAME" => "Malice", "GROUP" => "Assault Frigate", "IS_CRUISER" => 0],
                    ["ID" => 624, "NAME" => "Maller", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 12032, "NAME" => "Manticore", "GROUP" => "Stealth Bomber", "IS_CRUISER" => 0],
                    ["ID" => 609, "NAME" => "Maulus", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 37456, "NAME" => "Maulus Navy Issue", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 603, "NAME" => "Merlin", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 32209, "NAME" => "Mimir", "GROUP" => "Heavy Assault Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 623, "NAME" => "Moa", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 12015, "NAME" => "Muninn", "GROUP" => "Heavy Assault Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 592, "NAME" => "Navitas", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11377, "NAME" => "Nemesis", "GROUP" => "Stealth Bomber", "IS_CRUISER" => 0],
                    ["ID" => 2006, "NAME" => "Omen", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 17709, "NAME" => "Omen Navy Issue", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 11995, "NAME" => "Onyx", "GROUP" => "Heavy Interdiction Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 635, "NAME" => "Opux Luxury Yacht", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 33818, "NAME" => "Orthrus", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 620, "NAME" => "Osprey", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 29340, "NAME" => "Osprey Navy Issue", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 44993, "NAME" => "Pacifier", "GROUP" => "Covert Ops", "IS_CRUISER" => 0],
                    ["ID" => 17718, "NAME" => "Phantasm", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 12021, "NAME" => "Phobos", "GROUP" => "Heavy Interdiction Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 586, "NAME" => "Probe", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 33697, "NAME" => "Prospect", "GROUP" => "Expedition Frigate", "IS_CRUISER" => 0],
                    ["ID" => 597, "NAME" => "Punisher", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 12038, "NAME" => "Purifier", "GROUP" => "Stealth Bomber", "IS_CRUISER" => 0],
                    ["ID" => 11178, "NAME" => "Raptor", "GROUP" => "Interceptor", "IS_CRUISER" => 0],
                    ["ID" => 17812, "NAME" => "Republic Fleet Firetail", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11393, "NAME" => "Retribution", "GROUP" => "Assault Frigate", "IS_CRUISER" => 0],
                    ["ID" => 587, "NAME" => "Rifter", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 629, "NAME" => "Rupture", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 12019, "NAME" => "Sacrilege", "GROUP" => "Heavy Assault Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 631, "NAME" => "Scythe", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 29336, "NAME" => "Scythe Fleet Issue", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 11190, "NAME" => "Sentinel", "GROUP" => "Electronic Attack Ship", "IS_CRUISER" => 0],
                    ["ID" => 11942, "NAME" => "Silver Magnate", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 585, "NAME" => "Slasher", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 622, "NAME" => "Stabber", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 17713, "NAME" => "Stabber Fleet Issue", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 11198, "NAME" => "Stiletto", "GROUP" => "Interceptor", "IS_CRUISER" => 0],
                    ["ID" => 33470, "NAME" => "Stratios", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 33553, "NAME" => "Stratios Emergency Responder", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 17924, "NAME" => "Succubus", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11200, "NAME" => "Taranis", "GROUP" => "Interceptor", "IS_CRUISER" => 0],
                    ["ID" => 627, "NAME" => "Thorax", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 591, "NAME" => "Tormentor", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 593, "NAME" => "Tristan", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 2834, "NAME" => "Utu", "GROUP" => "Assault Frigate", "IS_CRUISER" => 0],
                    ["ID" => 11999, "NAME" => "Vagabond", "GROUP" => "Heavy Assault Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 3518, "NAME" => "Vangel", "GROUP" => "Heavy Assault Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 47270, "NAME" => "Vedmak", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 11365, "NAME" => "Vengeance", "GROUP" => "Assault Frigate", "IS_CRUISER" => 0],
                    ["ID" => 32880, "NAME" => "Venture", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 626, "NAME" => "Vexor", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 17843, "NAME" => "Vexor Navy Issue", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 34590, "NAME" => "Victorieux Luxury Yacht", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 3766, "NAME" => "Vigil", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 37454, "NAME" => "Vigil Fleet Issue", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 17722, "NAME" => "Vigilant", "GROUP" => "Cruiser", "IS_CRUISER" => 1],
                    ["ID" => 45530, "NAME" => "Virtuoso", "GROUP" => "Stealth Bomber", "IS_CRUISER" => 0],
                    ["ID" => 33673, "NAME" => "Whiptail", "GROUP" => "Interceptor", "IS_CRUISER" => 0],
                    ["ID" => 11371, "NAME" => "Wolf", "GROUP" => "Assault Frigate", "IS_CRUISER" => 0],
                    ["ID" => 17930, "NAME" => "Worm", "GROUP" => "Frigate", "IS_CRUISER" => 0],
                    ["ID" => 12003, "NAME" => "Zealot", "GROUP" => "Heavy Assault Cruiser", "IS_CRUISER" => 1]
                ]);
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists('ship_lookup');
        }
    }

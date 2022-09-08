<?php

namespace App\Models\Models\Partners;

use App\Connector\EveAPI\Universe\ResourceLookupService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function GuzzleHttp\Psr7\str;

class NPC
{


    public function __construct(
        public int $typeId,
        public int $groupID,
        public string $typeName,
        public string $description
    )
    {
    }

    public static function makeFromId(int $id) : NPC
    {

        return Cache::remember("npc.id-".$id, now()->addHour(), function () use ($id){
            // Get old dumps
            $tables = DB::table("previous_dumps_tables")->orderBy("ORDER_ASC", "ASC")->get();

            $item = null;
            // Try old dumps
            foreach ($tables as $table) {
                if (DB::table($table->TABLE_NAME)->where("typeID", '=', $id)->exists()) {
                    $item = DB::table($table->TABLE_NAME)->where("typeID", '=', $id)->first(['typeID', 'typeName', 'description', 'groupID']);
                    break;
                }
            }

            if (!$item) {
                return new NPC($id, 0, "Unknown NPC or can", "Unknown item.");
            }

            return new NPC($item->typeID, $item->groupID, $item->typeName, $item->description);
        });
    }


    public static function make(string $name) : NPC
    {
        return Cache::remember("npc.".Str::slug($name), now()->addHour(), function () use ($name){
            // Get old dumps
            $tables = DB::table("previous_dumps_tables")->orderBy("ORDER_ASC", "ASC")->get();

            $item = null;
            // Try old dumps
            foreach ($tables as $table) {
                if (DB::table($table->TABLE_NAME)->where("typeName", '=', $name)->exists()) {
                    $item = DB::table($table->TABLE_NAME)->where("typeName", '=', $name)->first(['typeID', 'typeName', 'description', 'groupID']);
                    break;
                }
            }

            if (!$item) {
                return new NPC(0, 0, "Unknown NPC/Loot can: " . $item->typeName, "Unknown item.");
            }

            return new NPC($item->typeID, $item->groupID, $item->typeName, $item->description);

        });
    }
}

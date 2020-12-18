<?php

namespace App\Console\Commands;

use App\Connector\EveAPI\Universe\ResourceLookupService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GetMissingItemMetadata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abyss:get-missing-metadata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets missing metadata from ESI';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $items = DB::table('item_prices')
            ->where('GROUP_ID', 0)
            ->where('GROUP_NAME', "TBD")->get();


        /** @var ResourceLookupService $esi */
        $esi = resolve("App\Connector\EveAPI\Universe\ResourceLookupService");



        foreach ($items as $i => $item) {
//            $this->line("[".Str::padLeft($i+1, 5)." / " . Str::padLeft($items->count(),5)."] - ".$item->NAME);
            try {
                $a = $esi->getItemInformation($item->ITEM_ID);
                $groupName = $esi->getGroupInfo($a['group_id'])['name'] ?? "TBD";
                DB::table('item_prices')->where('ITEM_ID', $item->ITEM_ID)->update([
                   'DESCRIPTION' => $a['description'],
                   'NAME' => $a['name'],
                   'GROUP_ID' => $a['group_id'],
                   'GROUP_NAME' => $groupName,
                ]);
                Log::info('Actualized data for '.$item->NAME. " ".$item->ITEM_ID. " ".($item->NAME != $a['name'] ? " new name: ".$a['name'] : ''));
            }
            catch (\Exception $e) {
                Log::error('Could not actualize '.$item->NAME." - ".$e->getMessage());
            }
        }

        return 0;
    }
}

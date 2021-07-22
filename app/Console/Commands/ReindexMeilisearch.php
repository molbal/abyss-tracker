<?php

namespace App\Console\Commands;

use App\Char;
use App\Fit;
use App\Http\Controllers\FitSearchController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use MeiliSearch\Client;
use MeiliSearch\Exceptions\ApiException;

class ReindexMeilisearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abyss:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reindexes meilisearch';

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
        $meili = new Client(config('tracker.meili.endpoint'), config('tracker.meili.masterKey'));
//        try {
//
//            $index = $meili->index('abyss');
//            $updateFrom = $index->getAllUpdateStatus();
//            if ($updateFrom === []) {
//                $updateFrom = Carbon::parse('1990-01-01 00:00:00');
//            }
//            else {
//                dd("now what? ", $updateFrom);
//            }
//        }
//        catch (\Exception $e) {
//            if ($e->getMessage() == "Index abyss not found") {
//                $index = $meili->createIndex('abyss');
//                $updateFrom = Carbon::parse('1990-01-01 00:00:00');
//            }
//            else {
//                throw  $e;
//            }
//        }



        $this->info('Queuing chars for indexing');
        try {
            $meili->deleteIndex('chars');
        }
        catch (\Exception $e) {}
        $charsIndex = $meili->createIndex('chars');
        Char::chunk(100, function ($chars) use ($charsIndex) {
            $formeili = [];
            foreach ($chars as $char) {
                /** @var  $char Char */
                $formeili[] = [
                    'id' => $char->CHAR_ID,
                    'name' => $char->NAME
                ];
            }
            $charsIndex->addDocuments($formeili, 'id');
        });
        $this->info('Queuing chars for indexing done');


        $this->info('Queuing fits for indexing');
        try {
            $meili->deleteIndex('fits');
        }
        catch (\Exception $e) {}
        $fitsIndex = $meili->createIndex('fits');
        /** @var FitSearchController $fss */
        $fss = resolve('App\Http\Controllers\FitSearchController');
        $fss->getStartingQuery(true)->orderBy('fits.ID')->chunk(100, function ($fits) use ($fitsIndex, $fss) {
            foreach ($fits as $fit) {
                /** @var  $fit Fit*/
                $formeili[] = [
                    'id' => $fit->ID,
                    'name' => $fit->NAME,
                    'hull' => $fit->SHIP_NAME,
                    'tags' => $fss->getFitTags($fit->ID)->where('TAG_VALUE', 1)->pluck('TAG_NAME')->map(fn($x) => __('tags.'.$x))->implode(', ')
                ];
            }
            $fitsIndex->addDocuments($formeili, 'id');
        });
        $this->info('Queuing fits for indexing done');


        $this->info('Queuing items for indexing');
        try {
            $meili->deleteIndex('items');
        }
        catch (\Exception $e) {}
        $fitsIndex = $meili->createIndex('items');
        /** @var FitSearchController $fss */
        $fss = resolve('App\Http\Controllers\FitSearchController');
        DB::table('item_prices')->orderBy('ITEM_ID')->chunk(100, function ($items) use ($fitsIndex, $fss) {
            foreach ($items as $item) {
                $formeili[] = [
                    'id' => $item->ITEM_ID,
                    'name' => $item->NAME
                ];
            }
            $fitsIndex->addDocuments($formeili, 'id');
        });
        $this->info('Queuing items for indexing done');
        return 0;
    }
}

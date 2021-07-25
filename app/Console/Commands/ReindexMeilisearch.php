<?php

namespace App\Console\Commands;

use App\Char;
use App\Fit;
use App\Http\Controllers\FitSearchController;
use App\Http\Controllers\HelperController;
use App\Pvp\PvpEvent;
use App\VideoTutorial;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
            $this->info('Deleting old index: chars');
            $meili->deleteIndex('chars');
            $this->info('Deleted old index: chars');
        }
        catch (\Exception $e) {
            $this->warn("Old index could not be deleted: ".$e->getMessage());
        }
        sleep(1);
        $charsIndex = $meili->createIndex('chars');
        Char::chunk(100, function ($chars) use ($charsIndex) {
            $this->info('Collecting info...');
            $formeili = [];
            foreach ($chars as $char) {
                /** @var  $char Char */
                $formeili[] = [
                    'id' => $char->CHAR_ID,
                    'name' => $char->NAME,
                    'img' => HelperController::getCharImgLink($char->CHAR_ID, 64),
                    'url' => route('profile.index', ['id' => $char->CHAR_ID])
                ];
            }
            $this->info('Sending chunk...');
            $charsIndex->addDocuments($formeili, 'id');
            $this->info('Sent chunk...');
        });
        $this->info('Queuing chars for indexing done');


        $this->info('Queuing fits for indexing');
        try {
            $this->info('Deleting old index: fits');
            $meili->deleteIndex('fits');
            $this->info('Deleted old index: fits');
        }
        catch (\Exception $e) {
            $this->warn("Old index could not be deleted: ".$e->getMessage());
        }
        sleep(1);
        $fitsIndex = $meili->createIndex('fits');
        /** @var FitSearchController $fss */
        $fss = resolve('App\Http\Controllers\FitSearchController');
        $fss->getStartingQuery(true)->orderBy('fits.ID')->chunk(100, function ($fits) use ($fitsIndex, $fss) {
            $this->info('Collecting info...');
            foreach ($fits as $fit) {
                /** @var  $fit Fit*/
                $formeili[] = [
                    'id' => $fit->ID,
                    'name' => $fit->NAME,
                    'hull' => $fit->SHIP_NAME,
                    'tags' => $fss->getFitTags($fit->ID)->where('TAG_VALUE', 1)->pluck('TAG_NAME')->map(fn($x) => __('tags.'.$x))->implode(', '),
                    'img' => HelperController::getRenderImgLink($fit->SHIP_ID, 64),
                    'url' => route('fit_single', ['id' => $fit->ID])
                ];
            }
            $this->info('Sending chunk...');
            $fitsIndex->addDocuments($formeili, 'id');
            $this->info('Sent chunk...');
        });
        $this->info('Queuing fits for indexing done');


        $this->info('Queuing items for indexing');
        try {
            $this->info('Deleting old index: items');
            $meili->deleteIndex('items');
            $this->info('Deleted old index: items');
        }
        catch (\Exception $e) {
            $this->warn("Old index could not be deleted: ".$e->getMessage());
        }
        sleep(1);
        $fitsIndex = $meili->createIndex('items');
        /** @var FitSearchController $fss */
        $fss = resolve('App\Http\Controllers\FitSearchController');
        DB::table('item_prices')->orderBy('ITEM_ID')->chunk(100, function ($items) use ($fitsIndex, $fss) {
            $this->info('Collecting info...');
            foreach ($items as $item) {
                $formeili[] = [
                    'id' => $item->ITEM_ID,
                    'name' => $item->NAME,
                    'img' => HelperController::getItemImgLink($item->ITEM_ID, 64),
                    'url' => route('item_single', ['item_id' => $item->ITEM_ID])
                ];
            }
            $this->info('Sending chunk...');
            $fitsIndex->addDocuments($formeili, 'id');
            $this->info('Sent chunk...');
        });
        $this->info('Queuing items for indexing done');


        $this->info('Queuing pvp events for indexing');
        try {
            $this->info('Deleting old index: pvp_events');
            $meili->deleteIndex('pvp_events');
            $this->info('Deleted old index: pvp_events');
        }
        catch (\Exception $e) {
            $this->warn("Old index could not be deleted: ".$e->getMessage());
        }
        sleep(1);
        $eventsIndex = $meili->createIndex('pvp_events');
        /** @var FitSearchController $fss */
        PvpEvent::orderBy('id')->chunk(100, function ($items) use ($eventsIndex, $fss) {
            $this->info('Collecting info...');
            foreach ($items as $item) {
                $formeili[] = [
                    'id' => $item->slug,
                    'name' => $item->name,
                    'img' => asset('event.webp'),
                    'url' => route('pvp.get', ['slug' => $item->slug])
                ];
            }
            $this->info('Sending chunk...');
            $eventsIndex->addDocuments($formeili, 'id');
            $this->info('Sent chunk...');
        });
        $this->info('Queuing pvp events for indexing done');


        $this->info('Queuing tutorials for indexing');
        try {
            $this->info('Deleting old index: tutorials');
            $meili->deleteIndex('tutorials');
            $this->info('Deleted old index: tutorials');
        }
        catch (\Exception $e) {
            $this->warn("Old index could not be deleted: ".$e->getMessage());
        }
        sleep(1);
        $tutorialsIndex = $meili->createIndex('tutorials');
        /** @var FitSearchController $fss */
        VideoTutorial::orderBy('id')->chunk(100, function ($items) use ($tutorialsIndex, $fss) {
            $this->info('Collecting info...');
            foreach ($items as $item) {
                $formeili[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'img' => asset('aura.webp'),
                    'url' => route('tutorials.get', ['id' => $item->id, 'slug' => Str::slug($item->name)])
                ];
            }
            $this->info('Sending chunk...');
            $tutorialsIndex->addDocuments($formeili, 'id');
            $this->info('Sent chunk...');
        });
        $this->info('Queuing tutorials for indexing done');
        return 0;
    }
}

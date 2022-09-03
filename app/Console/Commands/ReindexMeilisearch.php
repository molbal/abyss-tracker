<?php

namespace App\Console\Commands;

use App\Http\Controllers\FitSearchController;
use App\Http\Controllers\HelperController;
use App\Models\Char;
use App\Models\Fit;
use App\Models\VideoTutorial;
use App\Pvp\PvpEvent;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use MeiliSearch\Client;

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
        $meili = new Client(config('tracker.meili.endpoint'), config('tracker.meili.masterKey'), new \GuzzleHttp\Client([
            'timeout' => 2,
            'headers' => ['Accept-Encoding' => 'gzip'],
//            'debug' => true
        ]));
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
        Char::with('publicRuns')->whereRaw("CHAR_ID not in (select char_id from privacy where PANEL='TOTAL_RUNS' and DISPLAY='private')")->chunk(100, function ($chars) use ($charsIndex) {
            $this->info('Collecting info...');
            $formeili = [];
            foreach ($chars as $char) {
                /** @var  $char Char */
                $formeili[] = [
                    'id' => $char->CHAR_ID,
                    'name' => $char->NAME,
                    'img' => HelperController::getCharImgLink($char->CHAR_ID, 64),
                    'url' => route('profile.index', ['id' => $char->CHAR_ID]),
                    'runs' => $char->publicRuns()->count()
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
                /** @var  $fit \App\Models\Fit*/
                $formeili[] = [
                    'id' => $fit->ID,
                    'name' => $fit->NAME." (#".$fit->ID.")",
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
        DB::table('item_prices')->orderBy('ITEM_ID')->select(['ITEM_ID','NAME','PRICE_SELL','PRICE_BUY'])->chunk(100, function ($items) use ($fitsIndex, $fss) {
            $this->info('Collecting info...');
            foreach ($items as $item) {
                $formeili[] = [
                    'id' => $item->ITEM_ID,
                    'name' => $item->NAME,
                    'img' => HelperController::getItemImgLink($item->ITEM_ID, 64),
                    'url' => route('item_single', ['item_id' => $item->ITEM_ID]),
                    'sellPrice' => $item->PRICE_SELL,
                    'buyPrice' => $item->PRICE_BUY,
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
                /** @var $item PvpEvent */
                $formeili[] = [
                    'id' => $item->slug,
                    'name' => $item->name,
                    'img' => asset('event.webp'),
                    'url' => route('pvp.get', ['slug' => $item->slug]),
                    'from' => Carbon::parse($item->created_at)->toDateString(),
                    'to' => Carbon::parse($item->updated_at)->toDateString()
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
        VideoTutorial::with('content_creator')->orderBy('id')->chunk(100, function ($items) use ($tutorialsIndex, $fss) {
            $this->info('Collecting info...');
            foreach ($items as $item) {
                /** @var $item \App\Models\VideoTutorial */
                $formeili[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'img' => HelperController::getCharImgLink($item->content_creator->CHAR_ID ?? 1),
                    'url' => route('tutorials.get', ['id' => $item->id, 'slug' => Str::slug($item->name)]),
                    'creator' => $item->content_creator->NAME
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

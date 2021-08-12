<?php

namespace App\Console\Commands;

use App\Http\Controllers\EFT\FitHelper;
use App\Http\Controllers\EFT\ItemClassifier;
use App\Http\Controllers\Misc\MassItemSlotClassifier;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CacheItemClasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abyss:class-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches item classes';

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
    public function handle(FitHelper $helper)
    {
        $this->info('Starting item caching');
        DB::table('item_prices')
            ->leftJoin('item_slot', 'item_prices.ITEM_ID','=','item_slot.ITEM_ID')
            ->whereNull('item_slot.ITEM_SLOT')
            ->orderBy('item_prices.ITEM_ID')
            ->select(['item_prices.ITEM_ID'])->chunk(100, function (Collection $items) use ($helper) {

                $this->info('Starting processing chunk (size: '.$items->count().')');
                try {
                    $items->pluck('ITEM_ID')->map(fn ($itemId) => $helper->getItemSlot($itemId));
                }
                catch (Exception $e) {
                    $this->error('Error while classification: '.get_class($e).': '.$e->getMessage());
                }
                $this->info('Finished processing chunk.');

        });
        $this->info('Finished item caching');

        return 0;
    }
}

<?php

namespace App\Console\Commands;

use App\Pvp\PvpVictim;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReQueuePvpLosses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abyss:requeue-pvp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Requeues PVP loss fits';

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
        $victims = PvpVictim::whereRaw('killmail_id not in (select killmail_id from pvp_ship_stats where error_text is null and stats is not null)')->get();
        $this->info("Attempting to requeue ".$victims->count().' victims');
        foreach ($victims as $victim) {
            /** @var PvpVictim $victim */

            Log::debug('Requesting stats calculation for '.$victim->getKillboardLink());
            $this->info('Requesting stats calculation for '.$victim->getKillboardLink());
            try {
                PvpVictim::requestStatsCalculation($victim);
                sleep(5);
            } catch (\Exception $e) {
                Log::debug('Failed stats recalc: '.$e->getMessage());
                $this->error('Failed stats recalc: '.$e->getMessage());
            }
        }
        return 0;
    }
}

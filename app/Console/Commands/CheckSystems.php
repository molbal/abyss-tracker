<?php

namespace App\Console\Commands;

use App\Http\Controllers\StopwatchController;
use Illuminate\Console\Command;

class CheckSystems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abyss:checksys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks which pilots are in the Abyss';

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
     * @return mixed
     */
    public function handle()
    {
        /** @var StopwatchController $stopwatch */
        $stopwatch = resolve("App\Http\Controllers\StopwatchController");
        $allstart = time();
//        $this->info("Starting update at $allstart");
        do {
//            $this->info("Starting update - ".time());
            $bf = time();
            $stopwatch->updateEsi();
            $af = time();
            $runtime = ceil($af - $bf);
//            $this->info("Single run took $runtime seconds.");
            $wait = 10 - min(10, max(0, $runtime));
//            $this->info("Waiting for $wait seconds.");
            sleep($wait);
        } while(time()-$allstart < 60-($wait+1));
//        $this->info("Finished update at $allstart");
        unset($stopwatch);
        gc_collect_cycles();
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearExpiredSearches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abyss:clearsearch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears expires searches';

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
        DB::table("saved_searches")->where('expires', '<=', now())->delete();
        DB::unprepared('optimize table saved_searches;');
        return 0;
    }
}

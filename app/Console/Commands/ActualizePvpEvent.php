<?php

namespace App\Console\Commands;

use App\Pvp\PvpEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ActualizePvpEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abyss:events-pvp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        DB::beginTransaction();
        PvpEvent::whereIsCurrent(true)->update(['is_current' => false]);
        PvpEvent::whereDate('created_at', '<=', now())->whereDate('updated_at', '>=', now())->update(['is_current' => true]);
        DB::commit();
        return 0;
    }
}

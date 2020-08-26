<?php

    namespace App\Console\Commands;

    use App\Connector\EveAPI\Journal\JournalService;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\Log;

    class PullIngameDonations extends Command {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'abyss:igdonations';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Pulls ingame donations from ESI';

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct() {
            parent::__construct();
        }

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle() {
            /** @var JournalService $js */
            $js = resolve('\App\Connector\EveAPI\Journal\JournalService');

//            Log::info("Resolved js");
            try {
                $data = $js->getCharJournal(env("ID_VEETOR"), env("RT_VEETOR"));
//                Log::info("Data:".print_r($data,1)." for ".env("ID_VEETOR")." and ".env("RT_VEETOR"));
                foreach ($data as $donation) {

                    /** @var $donation \App\Http\Controllers\Misc\DTO\IngameDonor */
                    $donation->persist();
                }
            } catch (\Exception $e) {
                Log::error("Could not refresh donations:" . $e);
            }
        }
    }

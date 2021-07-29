<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('abyss:recalc')->dailyAt('11:00')->timezone('UTC')->withoutOverlapping()->runInBackground();
        $schedule->command('abyss:checksys')->everyMinute()->withoutOverlapping()->runInBackground();
        $schedule->command('abyss:igdonations')->hourly()->withoutOverlapping()->runInBackground();
        $schedule->command('abyss:clearsearch')->daily()->withoutOverlapping()->runInBackground();
        $schedule->command('abyss:get-missing-metadata')->hourly()->withoutOverlapping()->runInBackground();
        $schedule->command('abyss:requeue-pvp')->hourly()->withoutOverlapping()->runInBackground();
        $schedule->command('abyss:events-pvp')->dailyAt('11:01')->timezone('UTC')->withoutOverlapping()->runInBackground();
        $schedule->command('abyss:reindex')->everyTwoHours()->withoutOverlapping()->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

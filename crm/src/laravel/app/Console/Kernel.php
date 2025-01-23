<?php

namespace App\Console;

use App\Services\Events\EventsService;
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
        Commands\UpdateLastCommentDate::class,
        Commands\SendEventNotify::class,
        Commands\SendEventNotifyBeforeFreeClients::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            (new EventsService)->cronNotifies();
            (new EventsService)->cronNotifiesBeforeFreeClients();
        })
            ->everyMinute();
//            ->between('8:00', '21:00');  //todo: when send notify user settings

        $schedule->call(function () {
            (new EventsService)->cronFreeClients();
        })
            ->hourly();
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

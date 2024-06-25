<?php

namespace App\Console;

use App\Service\Autogong\AutogongService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        /*
        $schedule->call(function () {
            (new AutogongService())->allCarsGet();
        })->everyFiveMinutes();
        */

        //$schedule->job((new AutogongService())->allCarsGet())->everyMinute();
        /*
        $schedule->command('service:runAutogong')->everyFiveMinutes();
        $schedule->command('service:runOtopert')->everyFiveMinutes();
        $schedule->command('service:runSovtajyeri')->everyFiveMinutes();
        */
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

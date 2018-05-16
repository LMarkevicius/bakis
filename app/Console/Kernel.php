<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Settings;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\CheckForNewLunches::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      $settings = Settings::find(1);

      if (!empty($settings->daily)) {
        $schedule->command('CheckForNewLunches')->runInBackground()->dailyAt($settings->daily)->timezone('Europe/Vilnius');
      }

      if (!empty($settings->hourly)) {
        $hour = "0 */" . $settings->hourly . " * * *";

        $schedule->command('CheckForNewLunches')->runInBackground()->timezone('Europe/Vilnius')->cron($hour);
      }
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

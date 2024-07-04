<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->exec('cp /var/www/html/sisdiex/sisdiex-prod-public/storage/app/public/* /var/www/html/sisdiex-prod/storage/app/public/')
        ->everyMinute()
        ->appendOutputTo(storage_path('logs/anexos.log'));

        $schedule->command('ldap:import labs', [
            '--no-interaction',
         ])
         ->hourly()
         ->appendOutputTo(storage_path('logs/import-discentes.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

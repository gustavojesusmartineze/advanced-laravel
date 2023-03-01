<?php

namespace App\Console;

use App\Console\Commands\SendNewsletterCommand;
use App\Console\Commands\SendEmailVerificationReminderCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        SendNewsletterCommand::class,
        SendEmailVerificationReminderCommand::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
            ->evenInMaintenanceMode()
            ->sendOutputTo(storage_path('inspire.log'))
            ->everyMinute();

        $schedule->call(function() {
            echo "Hello There\n";
        })->everyFiveMinutes();

        $schedule->command(SendNewsletterCommand::class)
            ->withoutOverlapping()
            ->onOneServer()
            ->mondays();
        $schedule->command(SendEmailVerificationReminderCommand::class)
            ->onOneServer()
            ->daily();
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

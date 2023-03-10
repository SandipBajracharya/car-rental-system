<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Reservation;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $reservations = Reservation::where('status', 'Active')->select('id', 'start_cron', 'end_cron', 'is_reserved')->get();

        foreach ($reservations as $reservation) {
            $expression = '';
            if ($reservation->is_reserved) {
                $expression = $reservation->end_cron;
            } else {
                $expression = $reservation->start_cron;
            }
            $schedule->command('run:reservations --id='.$reservation->id)->cron($expression)->appendOutputTo(storage_path('logs/file/Reservations.log'));
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

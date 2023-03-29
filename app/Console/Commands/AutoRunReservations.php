<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\ReservationServices;
use Carbon\Carbon;

class AutoRunReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:reservations {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to auto run reservations.';

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
        Log::channel('schedular_error')->info('*** Command Start ***');
        echo Carbon::now() ." COMMAND START".PHP_EOL;
        $id = $this->option('id');
        $service = new ReservationServices();
        $res = $service->autoUpdateReservations($id);
        if ($res && $res['status'] == 'error') {
            echo $res['message'];
        }
        echo Carbon::now() ." COMMAND COMPLETED".PHP_EOL;
        Log::channel('schedular_error')->info('*** Command Completed ***');
    }
}

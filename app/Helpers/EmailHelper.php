<?php

namespace App\Helpers;

use App\Jobs\SendEmailJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class EmailHelper
{
    public static function emailSend($data)
    {
        $minute = Lang::get('email')['queue_time_delay_in_minute'];
        $emailJob = (new SendEmailJob($data))->delay(Carbon::now()->addMinutes($minute));
        dispatch($emailJob);
    }
}
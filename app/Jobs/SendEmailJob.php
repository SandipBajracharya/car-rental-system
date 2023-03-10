<?php

namespace App\Jobs;

use App\Mail\SendOrderEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->details;
        $name = $data['name'];
        $email = $data['email'];
        $process = $data['process'];
        $order = $data['order'];
        try {
            Mail::to($email)->send(new SendOrderEmail($process, $name, $order));
            Log::channel('email_queue')->info('Email sent');
        } catch (\Throwable $e) {
            Log::channel('email_queue')->error($e->getMessage());
        }
    }
}

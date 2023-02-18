<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class SendOrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $process;
    private $name;
    private $order;

    public function __construct($orderprocess = 1,$name,$order ='')
    {
        $this->process = $orderprocess;
        $this->name = $name;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $process = $this->process;
        $name = $this->name;
        $order = $this->order;
        if ($process == 1) {
            $subject = Lang::get('email')['subject_order'];
        } else if ($process == 2) {
            $subject = Lang::get('email')['subject_complete'];
        } else {
            $subject = Lang::get('email')['subject_cancel'];
        }
        return $this->from($address = 'no-reply@mg.tarabooks.com', config('app.name'))
        ->subject($subject)->markdown('emails.orderTemplate',compact('name','process','order'));
    }
}

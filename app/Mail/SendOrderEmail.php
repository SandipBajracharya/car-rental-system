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
        if (strtolower($process) == 'active') {
            $subject = Lang::get('email')['subject_order'];
            $content = Lang::get('email')['order_message'];
        } else if (strtolower($process) == 'completed') {
            $subject = Lang::get('email')['subject_complete'];
            $content = Lang::get('email')['completion_message'];
        } else {
            $subject = Lang::get('email')['subject_cancel'];
            $content = Lang::get('email')['cancel_message'];
        }
        return $this->from($address = 'no-reply@mg.tarabooks.com', config('app.name'))
        ->subject($subject)->markdown('emails.orderTemplate', compact('name', 'process', 'order', 'content'));
    }
}

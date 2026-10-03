<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data)
    {
    }

    public function build()
    {
        return $this
            ->subject('New website inquiry from ' . $this->data['name'])
            ->replyTo($this->data['email'], $this->data['name'])
            ->text('emails.contact');
    }
}
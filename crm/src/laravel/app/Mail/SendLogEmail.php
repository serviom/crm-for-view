<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendLogEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $link;
    protected $description;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $link, $description )
    {
        $this->title = $title;
        $this->link = $link;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Лог помилки")->markdown('emails.send_log_mail', [
            "title" => $this->title,
            "link" => $this->link,
            "description" => $this->description,
        ]);
    }
}

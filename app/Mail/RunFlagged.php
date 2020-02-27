<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RunFlagged extends Mailable
{
    use Queueable, SerializesModels;

    /** @var int */
    public $id;

    /** @var string */
    public $message;

    /**
     * RunFlagged constructor.
     *
     * @param int    $id
     * @param string $message
     */
    public function __construct(int $id, string $message) {
        $this->id = $id;
        $this->message = $message;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.flagged')
                    ->from(env("MAIL_USERNAME"))
                    ->subject(sprintf("Run #%d flagged", $this->id));
    }
}

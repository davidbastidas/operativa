<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMsg extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $mail;
    public $asunto;
    public $novedad;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $email, $asunto, $novedad)
    {
        $this->name = $nombre;
        $this->mail = $email;
        $this->asunto = $asunto;
        $this->novedad = $novedad;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.mensaje-enviado',
            ['name' => $this->name],
            ['mail' => $this->mail],
            ['asunto' => $this->asunto],
            ['novedad' => $this->novedad]
        );
    }
}

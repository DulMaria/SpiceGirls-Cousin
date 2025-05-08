<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TwoFactorCode extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function build()
    {
        Log::info('Enviando código 2FA: ' . $this->code . ' a destinatario');
        
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Tu código de verificación - ' . $this->code)  // Incluir código en asunto para debugging
            ->text('emails.auth.2fa_plain')
            ->with(['code' => $this->code])
            ->withSwiftMessage(function ($message) {
                $message->getHeaders()
                    ->addTextHeader('X-Priority', '1')
                    ->addTextHeader('X-MSMail-Priority', 'High')
                    ->addTextHeader('Importance', 'High');
            });
    }
}
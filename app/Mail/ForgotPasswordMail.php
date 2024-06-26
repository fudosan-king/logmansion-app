<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newPassword;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newPassword, $user)
    {
        $this->newPassword = $newPassword;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.forgot-password')
                    ->subject('パスワード変更のお知らせ【ログマンション購入者アプリ】')
                    ->with(['newPassword' => $this->newPassword, 'user' => $this->user]);
    }

}


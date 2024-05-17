<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminResetNotification extends Mailable {
    use Queueable, SerializesModels;

    protected $adminUser;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($adminUser, $password) {
        $this->adminUser = $adminUser;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this    
     */
    public function build() {
        return $this
            ->subject('abc')
            ->view('mail.reset_notification')
            ->with([
                'adminUser' => $this->adminUser,
                'password' => $this->password
            ]);
        }
}

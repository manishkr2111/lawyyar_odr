<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $resetUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $token)
    {
        $this->user = $user;

        // Correct reset URL using token + email
        $this->resetUrl = url('/reset-password?token=' . $token . '&email=' . $user->email);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Reset Password Mail')
            ->view('emails.reset_password')
            ->with([
                'user' => $this->user,
                'resetUrl' => $this->resetUrl
            ]);
    }
}

<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    /**
     * Create a new message instance.
     *
     * @param string $token The token to include in the reset password link.
     * @param string $email The email address of the user.
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $resetUrl = url('http://localhost:4200/new-password') . '?token=' . $this->token . '&email=' . urlencode($this->email);

        return $this->subject('Reset Your Password')
                    ->html("
                        <html>
                        <head>
                            <title>Reset Your Password</title>
                        </head>
                        <body>
                            <h1>Reset Your Password</h1>
                            <p>Click the link below to reset your password:</p>
                            <a href='{$resetUrl}'>Reset Password</a>
                        </body>
                        </html>
                    ");
    }
}


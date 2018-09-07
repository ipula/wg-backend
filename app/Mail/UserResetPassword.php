<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserResetPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $token;
    public $id;
    public $base_url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$token,$base_url)
    {
        $this->email = $email;
        $this->token = $token;
        $this->base_url = $base_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ipularanasinghe007@gmail.com')->subject('User Reset Password')
            ->view('email.reset_email');
    }
}
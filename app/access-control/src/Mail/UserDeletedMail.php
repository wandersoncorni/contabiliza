<?php

namespace App\AccessControl\Mail;

use App\AccessControl\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Exclusão de conta.')
                    ->view('access-control::emails.user-deleted');
    }
}

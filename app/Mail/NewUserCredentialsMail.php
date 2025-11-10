<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly ?string $plainPassword
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Your Empire Kitchens Account')
            ->view('emails.users.credentials', [
                'user' => $this->user,
                'plainPassword' => $this->plainPassword,
            ]);
    }
}

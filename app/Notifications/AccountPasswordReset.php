<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class AccountPasswordReset extends ResetPassword
{
    public function toMail($notifiable): MailMessage
    {
        $resetUrl = URL::to(
            route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false)
        );

        return (new MailMessage)
            ->subject('Reset Your Empire Kitchen Password')
            ->markdown('emails.password-reset', [
                'resetUrl' => $resetUrl,
                'user'     => $notifiable,
                'logoUrl'  => asset('empire-kitchengold-icon.png'),
                'appName'  => config('app.name', 'Empire Kitchen'),
            ]);
    }
}

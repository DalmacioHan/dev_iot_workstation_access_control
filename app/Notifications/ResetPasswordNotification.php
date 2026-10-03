<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotificationBase;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPasswordNotificationBase
{
    /**
     * Build the branded password reset email.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset your SLSU Workstation password')
            ->view('emails.auth.reset-password', [
                'user' => $notifiable,
                'resetUrl' => $url,
                'expireMinutes' => config(
                    'auth.passwords.' . config('auth.defaults.passwords') . '.expire'
                ),
            ]);
    }
}

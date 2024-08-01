<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordCustomized extends ResetPasswordNotification
{
    use Queueable;

    protected $user;

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }
        $this->user = $notifiable;
        return $notifiable->password === null ?
            $this->buildMailMessageRegistered($notifiable, $this->resetUrl($notifiable)) :
            $this->buildMailMessage($this->resetUrl($notifiable));
    }

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessageRegistered($user, $url)
    {
        $rol = $user->roles[0]['title'];
        $hoursLimit = minutesToHours(config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'));
        return app()->make(MailMessage::class)
            ->subject('Alta de Nuevo Usuario')
            ->markdown('mail.userCreated', [
                'user' => $user,
                'date' => date('d/m/Y'),
                'rol' => $rol,
                'url' => $url,
                'hoursLimit' => $hoursLimit,
            ]);
    }

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        $hoursLimit = minutesToHours(config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'));
        return (new MailMessage())
            ->subject(Lang::get('Reset Password Notification'))
            ->markdown('mail.resetPassword', [
                'url' => $url,
                'user' => $this->user,
                'count' => $hoursLimit
            ]);
    }
}

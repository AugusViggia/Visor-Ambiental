<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Point;

class PointWasReported extends Notification
{
    use Queueable;

    private Point $point;
    private string $reason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Point $point, string $reason)
    {
        $this->point = $point;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->subject('¡Punto denunciado!')
                    ->markdown('mail.pointWasReported', [
                        'user' => $notifiable,
                        'point' => $this->point,
                        'reason' => $this->reason,
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

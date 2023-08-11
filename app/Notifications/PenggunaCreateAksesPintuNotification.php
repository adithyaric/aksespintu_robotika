<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PenggunaCreateAksesPintuNotification extends Notification
{
    use Queueable;

    protected $aksesPintu;

    public function __construct($aksesPintu)
    {
        $this->aksesPintu = $aksesPintu;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('A new access has been created by '.$this->aksesPintu->user->name)
            ->action('Accept', url("/akses/{$this->aksesPintu->id}/accept"))
            ->line('Click the button above to change the status of the AksesPintu to aktif.');
    }
}

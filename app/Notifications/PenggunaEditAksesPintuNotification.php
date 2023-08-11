<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PenggunaEditAksesPintuNotification extends Notification
{
    use Queueable;

    protected $aksesPintuRequest;

    public function __construct($aksesPintuRequest)
    {
        $this->aksesPintuRequest = $aksesPintuRequest;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $approveUrl = url("/admin/akses-pintu-requests/{$this->aksesPintuRequest->id}/approve");
        $rejectUrl = url("/admin/akses-pintu-requests/{$this->aksesPintuRequest->id}/reject");

        return (new MailMessage)
            ->line('A new access has been created by '.$this->aksesPintuRequest->user->name)
            ->line("<a href='{$approveUrl}' class='button button-primary' target='_blank'>Approve</a>")
            ->line("<a href='{$rejectUrl}' class='button button-primary' target='_blank'>Reject</a>")
            ->line('Click the button above to change the status of the AksesPintu to aktif.');
    }
}

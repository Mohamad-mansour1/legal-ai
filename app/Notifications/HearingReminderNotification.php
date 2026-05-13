<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class HearingReminderNotification extends Notification
{
    use Queueable;

    public function __construct(
        public $hearing
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [

            'title' => 'Upcoming Hearing',

            'message' => 'You have a hearing tomorrow: '
                . $this->hearing->title,

            'case_id' => $this->hearing->legal_case_id,

            'hearing_id' => $this->hearing->id,

        ];
    }
}
<?php

namespace App\Notifications;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MembershipExpiryNotification extends Notification
{
    use Queueable;

    public function __construct(protected Member $member, protected string $status)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $greeting = $this->status === 'expired'
            ? 'Membership expired'
            : 'Membership expiring soon';

        $line = $this->status === 'expired'
            ? 'Your membership has expired. Please make a payment to renew your plan and continue training.'
            : 'Your membership is about to expire in the next 3 days. Please renew your plan soon.';

        return (new MailMessage)
            ->subject('Gym Membership Notification')
            ->greeting($greeting)
            ->line('Hello ' . $this->member->name . ',')
            ->line($line)
            ->line('Plan: ' . $this->member->plan->name)
            ->line('Expiry date: ' . $this->member->expiry_date->format('Y-m-d'))
            ->line('Workout level: ' . ucfirst($this->member->workout_level))
            ->line('Diet level: ' . ucfirst($this->member->diet_level));
    }
}

<?php

namespace App\Notifications\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Illuminate\Notifications\Messages\MailMessage;

class RegisteredNotification extends Notification
{
    use Queueable;

    public $loginCode;
    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user)
    {
        $this->loginCode = rand(111111, 999999);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', TwilioChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Prepare for your first ride')
            ->view('emails.users.welcome',[ 'user' => $this->user, 'data' => $this->loginCode ]);
    }

    public function toTwilio($notifiable)
    {


        $notifiable->login_code = $this->loginCode;
        $notifiable->save();

        return (new TwilioSmsMessage())
            ->content("Myride login code is {$this->loginCode}. Do not share this code with anyone");    
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

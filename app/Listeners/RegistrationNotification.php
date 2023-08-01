<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\UserRegistered;
use App\Notifications\Auth\RegisteredNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrationNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $event->user->notify(new RegisteredNotification($event->user));
    }
}

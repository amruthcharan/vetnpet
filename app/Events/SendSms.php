<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendSms extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(String $message, String $mobile)
    {
        $this->message = $message;
        $this->mobile = $mobile;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}

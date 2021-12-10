<?php

namespace App\Events;

use App\Events\Event;

class SendSms extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(String $message, String $mobile, String $template_id)
    {
        $this->message = $message;
        $this->mobile = $mobile;
        $this->template_id = $template_id;
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

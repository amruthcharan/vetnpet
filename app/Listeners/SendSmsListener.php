<?php

namespace App\Listeners;

use App\Events\SendSms;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSmsListener
{
    const USERNAME = "vetnpet";
    const PASSWORD = "gETSRI@71";
    const SENDER = "VetPet";
    
    /**
     * Handle the event.
     *
     * @param  SendSms  $event
     * @return void
     */
    public function handle(SendSms $event)
    {
        $url = "login.bulksmsgateway.in/sendmessage.php?user=" . urlencode(self::USERNAME) . "&password=" . urlencode(self::PASSWORD) . "&mobile=" . urlencode($event->mobile) . "&message=" . urlencode($event->message) . "&sender=" . urlencode(self::SENDER) . "&type=" . urlencode('3');

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);

        curl_close($ch);
    }
}

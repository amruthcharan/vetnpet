<?php

namespace App\Listeners;

use App\Events\SendSms;
use GuzzleHttp\Client;

class SendSmsListener
{
    const USERNAME = "vetnpet";
    const PASSWORD = "9502505";
    const SENDER = "VetPet";


    public function handle(SendSms $event)
    {
        $url = "login.bulksmsgateway.in/sendmessage.php?user=" . self::USERNAME . "&password=" . self::PASSWORD . "&mobile=" . $event->mobile . "&message=" . $event->message . "&sender=" . self::SENDER . "&type=" . '3' . "&template_id=" . $event->template_id;

        $client = new Client();
        $response = $client->get($url);
        return $response->getBody()->getContents();
    }
}

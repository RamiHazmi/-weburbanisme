<?php
require_once   'C:/xampp/htdocs/urbanisme/twilio-php/src/Twilio/autoload.php';  
use Twilio\Rest\Client;


class Notification
{
  

   
    public function sendSMS($to, $message)
    {
        $client = new Client($this->sid, $this->token);
        $client->messages->create(
            $to,
            [
                'from' => $this->from,
                'body' => $message
            ]
        );
    }
}
?>

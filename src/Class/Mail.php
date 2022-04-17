<?php

namespace App\Class;
use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = '37047bc65bea13ef80f2a8289870c3c7';
    private $api_key_secret = 'de0bb68230ecffa2e5a9f41ff291abf9';

    public function send($to_email, $from_email, $from_name, $subject, $establishment, $message)
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Name' => 'Hypnos'
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                        ]
                    ],
                    'TemplateID' => 3874236,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'email' => $from_email,
                        'from' => $from_name,
                        'subject' => $subject,
                        'establishment' => $establishment,
                        'message' => $message,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
    }
}

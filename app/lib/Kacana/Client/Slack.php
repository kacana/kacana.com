<?php namespace Kacana\Client;
use Maknz\Slack\Client;
use Illuminate\Support\Facades\Auth;

Class Slack {

    private $_url;

    private $_client;

    public function __construct()
    {
        $this->_url = KACANA_INCOMING_WEB_HOOK_URL.KACANA_INCOMING_WEB_HOOK_KEY;
        $settings = [
            'username' => 'Kacana Bot',
            'channel' => '#don_hang',
            'link_names' => true
        ];

        $this->_client = new Client($this->_url, $settings);
    }

    public function testSend($message, $attach){



        $this->_client->attach($attach)->send($message);
    }

    public function notificationNewOrder(){



        $attach = [
            'fallback' => 'Current server stats',
            'text' => 'Current server stats',
            'color' => 'success',
            'fields' => [
                [
                    'title' => 'CPU usage',
                    'value' => '90%',
                    'short' => true // whether the field is short enough to sit side-by-side other fields, defaults to false
                ],
                [
                    'title' => 'RAM usage',
                    'value' => '2.5GB of 4GB',
                    'short' => true
                ]
            ]
        ];


    }
}
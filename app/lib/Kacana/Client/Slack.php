<?php namespace Kacana\Client;
use Maknz\Slack\Client;
use Illuminate\Support\Facades\Auth;

Class Slack {

    private $_url;

    private $_client;

    public function __construct($channel = '#don_hang')
    {
        $this->_url = KACANA_INCOMING_WEB_HOOK_URL.KACANA_INCOMING_WEB_HOOK_KEY;
        $settings = [
            'username' => 'Kacana Bot',
            'channel' => $channel,
            'link_names' => true
        ];

        $this->_client = new Client($this->_url, $settings);
    }

    public function send($message, $attach){

        $this->_client->attach($attach)->attach($attach)->send($message);
    }

    public function notificationNewOrder($slackText, $attachAddress, $attachProducts){
        $querySend = $this->_client->attach($attachAddress);

        foreach ($attachProducts as $attachProduct)
        {
            $querySend = $querySend->attach($attachProduct);
        }
        $querySend->send($slackText);
    }

    public function notificationNewMessage($threadId, $body, $tracking)
    {
        $attachAddress = [
            'color' => '#FA5858',
            "title"=> "User URL",
            "title_link"=> $tracking->url,
        ];
        $querySend = $this->_client->attach($attachAddress);
        $querySend->send('`#'.$threadId.'` '.$body);
    }
}
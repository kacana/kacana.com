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
            'username' => 'Cuong',
            'channel' => '#don_hang',
            'link_names' => true
        ];

        $this->_client = new Client($this->_url, $settings);
    }

    public function testSend(){
        $this->_client->send('asdasdasdasd');
    }
}
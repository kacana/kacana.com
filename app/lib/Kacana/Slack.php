<?php namespace Kacana;
use Maknz\Slack\Client;
use Illuminate\Support\Facades\Auth;

Class Slack {
    public function __construct()
    {
        $client = new Client('');

    }
}
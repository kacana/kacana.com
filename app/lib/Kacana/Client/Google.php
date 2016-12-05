<?php
namespace Kacana\Client;
/**
 * Description of Binumi_Facebook
 *
 * @author superbiff
 */
use Symfony\Component\HttpKernel\Client;

/**
 * Class Google
 * @package Kacana\Client
 */
class Google
{
    /**
     * @var \Google_Client
     */
    protected $_googleClient;

    protected $_googleOauth;

    /**
     * Google constructor.
     */
    public function __construct() {
        $this->_googleClient = new \Google_Client();
        $this->_googleClient->setClientId(KACANA_SOCIAL_GOOGLE_KEY);
        $this->_googleClient->setClientSecret(KACANA_SOCIAL_GOOGLE_SECRET);
        $this->_googleClient->setApplicationName(KACANA_SOCIAL_GOOGLE_APP_NAME);
        $this->_googleClient->setRedirectUri('postmessage');
    }

    /**
     * @return \Google_Client
     */
    public function getGoogleClient(){
        return $this->_googleClient;
    }

    public function getProfile($token) {
        $ticket = $this->_googleClient->verifyIdToken($token);
        if ($ticket) {
            $data = $ticket->getAttributes();
            return $data['payload']['sub']; // user ID
        }
        return false;
    }

    public function getGoogleServiceOauth2(){
        $this->_googleOauth = new \Google_Service_Oauth2($this->_googleClient);
        return $this->_googleOauth;
    }

    // Shorten a URL
    public function shorten($longUrl) {
        $this->_googleClient->setAccessToken(json_encode(["access_token" => 'ya29.Ci-nA63j_-YJy7-M4u0F490pttfSg-Gka2xLyDzaqmfWgDCMXLVsisYGoGLmqT55Vg']));
        $service = new \Google_Service_Urlshortener($this->_googleClient);

        $url = new \Google_Service_Urlshortener_Url();
        $url->longUrl = $longUrl;

        print_r($service->url->insert($url));die;
        return $service->url->insert($url);
    }
}
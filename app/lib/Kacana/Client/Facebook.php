<?php
namespace Kacana\Client;
use Facebook\FacebookApp;
use Facebook\FacebookRequest;

/**
 * Description of Binumi_Facebook
 *
 * @author superbiff
 */
class Facebook extends \Facebook\Facebook
{
    /**
     * Construct
     */
    public function __construct() {
        $config = array(
            'app_id' => KACANA_SOCIAL_FACEBOOK_KEY,
            'app_secret' => KACANA_SOCIAL_FACEBOOK_SECRET,
            'default_graph_version' => 'v2.8',
        );

        parent::__construct($config);
    }

    /**
     * Get current user's profile
     *
     * @throws \Facebook\Exceptions\FacebookResponseException
     * @throws \Facebook\Exceptions\FacebookSDKException
     * @return array
     */
    public function getProfile()
    {
        try {
            $param = array (
                'fields' => 'id,email,first_name,last_name,gender,hometown,link,languages,name,timezone,updated_time,verified,likes, picture',
            );

            $request = $this->makeRequest('GET', '/me', $param);

            return $request->getGraphUser()->asArray();

        } catch(\Facebook\Exceptions\FacebookResponseException $e) {

            throw $e;

        } catch(\Facebook\Exceptions\FacebookSDKException $e) {

            throw $e;

        }
    }

    public function makeRequest($method, $endpoint, $param = null, $accessToken = null){

        if(!$accessToken)
            $accessToken = $this->getDefaultAccessToken();

        $request = new FacebookRequest(
            $this->getApp(),
            $accessToken,
            $method,
            $endpoint,
            $param
        );

        return $this->getClient()->sendRequest($request);
    }

    public function addTestUser($uid, $name){
        try {

            $param = array (
                'installed' => 'true',
                'owner_access_token' => $this->getDefaultAccessToken()
            );

            $request = $this->makeRequest('POST', KACANA_SOCIAL_FACEBOOK_KEY.'/accounts/test-users', $param, $this->getApp()->getAccessToken());

            return $request->getGraphUser()->asArray();


        } catch(\Facebook\Exceptions\FacebookResponseException $e) {

            throw $e;

        } catch(\Facebook\Exceptions\FacebookSDKException $e) {

            throw $e;

        }
    }

    public function postPhoto($url, $caption, $publish = false){
        try {

            $param = array (
                'url' => $url,
                'caption' => $caption,
                'published' => $publish
            );

            $request = $this->makeRequest('POST', '/me/photos', $param);

            return $request->getGraphUser()->asArray();
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            throw $e;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            throw $e;
        }
    }

    public function postFeed($arrayFbMedia, $descPost){
        try {
            $param = [];
            for($i=0; $i<count($arrayFbMedia); $i++){
                $key = strval('attached_media['.$i.']');
                $value = json_encode(['media_fbid' => $arrayFbMedia[$i]['id']]);
                $param[$key] = $value;
            }
            $param['message'] = $descPost;

            $request = $this->makeRequest('POST', '/me/feed', $param);

            return $request->getGraphUser()->asArray();
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            throw $e;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            throw $e;
        }
    }
}

?>
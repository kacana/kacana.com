<?php
namespace Kacana\Client;
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
            'default_graph_version' => 'v2.5',
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

            $response = $this->get('/me?fields=id,bio,email,first_name,last_name,gender,hometown,link,languages,name,timezone,updated_time,verified,likes, picture');

            return $response->getGraphUser()->asArray();

        } catch(\Facebook\Exceptions\FacebookResponseException $e) {

            throw $e;

        } catch(\Facebook\Exceptions\FacebookSDKException $e) {

            throw $e;

        }
    }

}

?>
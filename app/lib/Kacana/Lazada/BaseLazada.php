<?php
namespace Kacana\Lazada;
use GuzzleHttp\Client;

class BaseLazada {

    private $_client;

    public function __construct($key = false, $userId = false, $uri = false)
    {

    }

    public function generateSignature($action){
        date_default_timezone_set("UTC");

        $parameters = $this->createBaseParameter($action);

        $encoded = array();
        foreach ($parameters as $name => $value) {
            $encoded[] = rawurlencode($name) . '=' . rawurlencode($value);
        }

        $concatenated = implode('&', $encoded);

        $api_key = KACANA_LAZADA_API_KEY;
        $parameters['Signature'] = rawurlencode(hash_hmac('sha256', $concatenated, $api_key, false));
        return $parameters;
    }

    private function createBaseParameter($action){

        $now = new \DateTime();
        $parameters = array(
            // The user ID for which we are making the call.
            'UserID' => KACANA_LAZADA_API_USER_ID,

            // The API version. Currently must be 1.0
            'Version' => '1.0',

            // The API method to call.
            'Action' => $action,

            // The format of the result.
            'Format' => 'JSON',

            // The current time formatted as ISO8601
            'Timestamp' => $now->format(\DateTime::ISO8601)
        );

        // Sort parameters by name.
        ksort($parameters);

        return $parameters;
    }

    private function makeRequest($parameters, $type = 'post'){
        $queryString = http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
        $url = KACANA_LAZADA_API_URL.'?'.$queryString;
        $client = new Client();
        $results = $client->request($type, $url);
        $body = \GuzzleHttp\json_decode($results->getBody());

        return $body->SuccessResponse->Body;

    }

    public function getCategoryTree(){
        $parameters = $this->generateSignature('GetCategoryTree');
        return $this->makeRequest($parameters);
    }

}
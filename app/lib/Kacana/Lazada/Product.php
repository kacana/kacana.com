<?php
namespace Kacana\Lazada;
use GuzzleHttp\Client;

class Product extends BaseLazada {

    public function createProduct($content){
        $parameters = $this->generateSignature('CreateProduct');
        $queryString = http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
        $url = KACANA_LAZADA_API_URL.'?'.$queryString;

        $client = new Client();

        $results = $client->request('POST', $url, [
                                    'headers'  => ['Content-Type' => 'application/x-www-form-urlencoded'],
                                    'body'     => $content
                                ]
                            );

        return \GuzzleHttp\json_decode($results->getBody());

    }

    public function getCategory(){
        return $this->getCategoryTree();
    }

    public function migrateImage($content){
        $parameters = $this->generateSignature('MigrateImage');
        $queryString = http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
        $url = KACANA_LAZADA_API_URL.'?'.$queryString;

        $client = new Client();

        $results = $client->request('POST', $url, [
                'headers'  => ['Content-Type' => 'application/x-www-form-urlencoded'],
                'body'     => $content
            ]
        );
        $results = \GuzzleHttp\json_decode($results->getBody());

        if(isset($results->ErrorResponse))
            return false;
        else
            return $results->SuccessResponse->Body->Image;
    }

}
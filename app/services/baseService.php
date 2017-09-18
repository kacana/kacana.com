<?php namespace App\services;

use App\models\baseModel;
use UAParser\Parser;

/**
 * Class baseService
 * @package App\services
 */
class baseService {

    /**
     * @var baseModel
     */
    public $_baseModel;

    /**
     * baseService constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param $id
     * @param $status
     * @return mixed
     */
    public function changefieldDropdown($id, $status, $field, $table){
        $baseModel = new baseModel();
        return $baseModel->changefieldDropdown($id, $status, $field, $table);
    }

    public function updateField($id, $content, $field, $table){
        $baseModel = new baseModel();
        return $baseModel->updateField($id, $content, $field, $table);
    }

    public function getIpInformation($ip)
    {
        return json_decode(file_get_contents('http://freegeoip.net/json/'.$ip));;
    }

    public function parserUserAgent($userAgent){
        $parser = Parser::create();
        $result = $parser->parse($userAgent);

        return $result;
    }

    public function trimElementDesc($description)
    {
        preg_match_all('#<p.*?>([^>]*)</p>#i', $description, $data);
        $listElement = $data[0];
        foreach ($listElement as $item) {
            if(!trim(strip_tags($item)) && !strpos('img', $item))
            {
                $from = '/' . preg_quote($item, '/') . '/';
                $description = preg_replace($from, '', $description, 1);
            }
        }
        return $description;
    }


}



?>
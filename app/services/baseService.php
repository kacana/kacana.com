<?php namespace App\services;

use App\models\baseModel;

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

}



?>
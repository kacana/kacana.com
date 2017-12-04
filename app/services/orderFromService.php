<?php namespace App\services;

use App\models\orderFromModel;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;

/**
 * Class orderFromService
 * @package App\services
 */
class orderFromService extends baseService
{

    /**
     * @var orderFromModel
     */
    private $_orderFrom;

    /**
     * orderFromService constructor.
     */
    public function __construct()
    {
        $this->_orderFrom = new orderFromModel();
    }

    public function createOrderFrom($title, $description, $userId)
    {
        return $this->_orderFrom->createItem($title, $description, $userId);
    }

    public function generateOrderFromTable($request)
    {
        $orderFromModel = new orderFromModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array('db' => 'order_froms.id', 'dt' => 0),
            array('db' => 'order_froms.name', 'dt' => 1),
            array('db' => 'order_froms.description', 'dt' => 2),
            array('db' => 'users.name AS author_name', 'dt' => 3),
            array('db' => 'order_froms.created_at', 'dt' => 4),
            array('db' => 'order_froms.updated_at', 'dt' => 5)
        );

        $return = $orderFromModel->generateOrderFromTable($request, $columns);
        $return['data'] = $datatables::data_output($columns, $return['data']);

        return $return;
    }

    public function updateOrderFrom($id, $title, $description)
    {
        return $this->_orderFrom->updateItem($id, $title, $description);
    }

    public function getListOrderFrom(){
        return $this->_orderFrom->getAll();
    }

}


?>
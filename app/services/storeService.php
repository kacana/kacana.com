<?php namespace App\services;

use App\models\campaignProductModel;
use App\models\storeModel;
use App\models\storeProductModel;
use Kacana\ViewGenerateHelper;
use Kacana\DataTables;

class storeService extends baseService
{

    private $_storeModel;

    private $_storeProductModel;

    public function __construct()
    {
        $this->_storeModel = new storeModel();
        $this->_storeProductModel = new storeProductModel();
    }

    public function getStoreById($storeId)
    {
        return $this->_storeModel->getItem($storeId);
    }

    /**
     * @param $storeId
     * @param $request
     * @return array
     */
    public function generateStoreProductTable($storeId, $request){
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();
        $campaignProduct = new campaignProductModel();

        $columns = array(
            array( 'db' => 'stores.name AS store_name', 'dt' => 0 ),
            array( 'db' => 'products.name', 'dt' => 1 ),
            array( 'db' => 'tags.name AS product_property_name', 'dt' => 2 ),
            array( 'db' => 'products.image', 'dt' => 3 ),
            array( 'db' => 'products.sell_price', 'dt' => 4 ),
            array( 'db' => 'store_products.quantity', 'dt' => 5 ),
            array( 'db' => 'campaign_products.id AS campaign_product', 'dt' => 6 ),
            array( 'db' => 'store_products.updated_at', 'dt' => 7 ),
            array( 'db' => 'store_products.product_property_id AS product_property_id', 'dt' => 8 )
        );

        $return = $this->_storeProductModel->generateStoreProductTable($storeId, $request, $columns);

        if(count($return['data'])) {
            foreach ($return['data'] as &$res) {
                if($res->campaign_product) {
                    $campaignProducts = $campaignProduct->getCampaignByProductId($res->id);
                    foreach ($campaignProducts as &$campaignProduct){
                        $campaignProduct->product_ref = $campaignProduct->productRef;
                        $campaignProduct->product;
                    }
                    $res->campaign_product = $campaignProducts;
                }
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }
}
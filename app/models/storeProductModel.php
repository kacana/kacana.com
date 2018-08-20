<?php namespace App\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;
use Kacana\DataTables;


class storeProductModel extends Model  {

    protected $table = 'store_products';

    public function productProperty()
    {
        return $this->belongsTo('App\models\productPropertiesModel', 'product_property_id');
    }

    public function store()
    {
        return $this->belongsTo('App\models\stores', 'store_id');
    }

    public function generateStoreProductTable($storeId, $request, $columns){
        $datatables = new DataTables();
        $limit = $datatables::limit($request, $columns);
        $order = $datatables::order($request, $columns);
        $where = $datatables::filter($request, $columns);

        // Main query to actually get the data
        $selectData = DB::table('store_products')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('product_properties', 'store_products.product_property_id', '=', 'product_properties.id')
            ->leftJoin('tags', 'product_properties.tag_color_id', '=', 'tags.id')
            ->leftJoin('products', 'product_properties.product_id', '=', 'products.id')
            ->leftJoin('campaign_products', 'campaign_products.product_id', '=', 'products.id')
            ->leftJoin('stores', 'store_products.store_id', '=', 'stores.id')
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit'])
            ->where('store_products.store_id', $storeId);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('store_products')
            ->leftJoin('product_properties', 'store_products.product_property_id', '=', 'product_properties.id')
            ->leftJoin('tags', 'product_properties.tag_color_id', '=', 'tags.id')
            ->leftJoin('products', 'product_properties.product_id', '=', 'products.id')
            ->leftJoin('campaign_products', 'campaign_products.product_id', '=', 'products.id')
            ->leftJoin('stores', 'store_products.store_id', '=', 'stores.id')
            ->select($datatables::pluck($columns, 'db'))
            ->where('store_products.store_id', $storeId);;

        if ($where) {
            $selectData->whereRaw($where);
            $recordsFiltered->whereRaw($where);
        }

        /*
         * Output
         */
        return array(
            "draw" => intval($request['draw']),
            "recordsTotal" => intval($selectLength->count()),
            "recordsFiltered" => intval($recordsFiltered->count()),
            "data" => $selectData->get()
        );
    }

}
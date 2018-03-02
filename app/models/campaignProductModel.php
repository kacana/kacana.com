<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Redis\Database;
use DB;
use Kacana\DataTables;

class campaignProductModel extends Model {

    protected $table = 'campaign_products';

    public function campaign()
    {
        return $this->belongsTo('App\models\campaignModel');
    }

    public function product()
    {
        return $this->belongsTo('App\models\productModel');
    }

    public function validateProducts($listProduct, $dateStart, $dateEnd){

        $products = $this->whereIn('product_id', $listProduct)
            ->where(function ($query) use ($dateStart, $dateEnd){
            $query->where(function ($query) use ($dateStart){
                $query->where('start_date', '<=', $dateStart)
                    ->where('end_date', '>=', $dateStart);
            })->orWhere(function ($query) use ($dateEnd){
                $query->where('start_date', '<=', $dateEnd)
                    ->where('end_date', '>=', $dateEnd);
            });
        });

        return $products->get();
    }

    public function createNewItem($productId, $campaignId, $discountType, $ref, $dateStart, $dateEnd){
        $campaignProduct = new campaignProductModel();
        $campaignProduct->product_id = $productId;
        $campaignProduct->campaign_id = $campaignId;
        $campaignProduct->discount_type = $discountType;
        $campaignProduct->ref = $ref;
        $campaignProduct->start_date = $dateStart;
        $campaignProduct->end_date = $dateEnd;

        $campaignProduct->save();

        return $campaignProduct;
    }

    public function generateCampaignProductTable($request, $columns, $campaignId){
        $datatables = new DataTables();

        $limit = $datatables::limit($request, $columns);
        $order = $datatables::order($request, $columns);
        $where = $datatables::filter($request, $columns);

        // Main query to actually get the data
        $selectData = DB::table('campaign_products')
            ->leftJoin('products', 'products.id', '=', 'campaign_products.product_id')
            ->select($datatables::pluck($columns, 'db'))
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit'])
            ->where('campaign_products.campaign_id', $campaignId);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('campaign_products')
            ->leftJoin('products', 'products.id', '=', 'campaign_products.product_id')
            ->select($datatables::pluck($columns, 'db'))
            ->where('campaign_products.campaign_id', $campaignId);

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

    public function deleteItem($id){
        $this->where('id', $id)->delete();
    }

}

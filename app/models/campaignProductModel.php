<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

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

}

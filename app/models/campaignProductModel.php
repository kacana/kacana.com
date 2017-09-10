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

}

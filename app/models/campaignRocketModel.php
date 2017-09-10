<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

class campaignRocketModel extends Model {

    protected $table = 'campaign_rockets';

    public function campaign()
    {
        return $this->belongsTo('App\models\campaignModel');
    }

}

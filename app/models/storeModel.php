<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Kacana\DataTables;


class storeModel extends Model  {

    protected $table = 'stores';

    /**
     * Get the user associated with product
     */
    public function city()
    {
        return $this->belongsTo('App\models\addressCityModel', 'city_id');
    }

    /**
     * Get the user associated with product
     */
    public function district()
    {
        return $this->belongsTo('App\models\addressDistrictModel', 'district_id');
    }

    /**
     * Get the user associated with product
     */
    public function ward()
    {
        return $this->belongsTo('App\models\addressWardModel', 'ward_id');
    }

    public function getAll(){
        return $this->get();
    }

    public function getItem($storeId){
        return $this->find($storeId);
    }
}
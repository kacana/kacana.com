<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class addressWardModel
 * @package App\models
 */
class addressWardModel extends Model {

    /**
     * @var string
     */
    protected $table = 'address_ward';
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the city that owns the ward.
     */
    public function city()
    {
        return $this->belongsTo('App\models\addressCityModel', 'city_id');
    }

    /**
     * Get the city that owns the ward.
     */
    public function district()
    {
        return $this->belongsTo('App\models\addressDistrictModel', 'district_id');
    }

    /**
     * Get the address receive associated with address ward
     */
    public function addressReceive()
    {
        return $this->hasMany('App\models\addressReceiveModel');
    }

    /*
     * function name: getItemsByCityId
     * @params: city_id
     * @return list wards
     */
    /**
     * @param $id
     * @return mixed
     */
    public function getItemsByCityId($id){
        return $this->where('city_id', $id)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll(){
        return $this->all();
    }

    /**
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getById($id){
        return $this->find($id);
    }
}

<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class addressDistrictModel
 * @package App\models
 */
class addressDistrictModel extends Model {

    /**
     * @var string
     */
    protected $table = 'address_district';
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the ward owns with this city
     */
    public function city()
    {
        return $this->belongsTo('App\models\addressCityModel', 'city_id');
    }

    /**
     * Get the address receive associated with address city
     */
    public function addressReceive()
    {
        return $this->hasMany('App\models\addressReceiveModel');
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


    /**
     * @param $name
     * @param $cityId
     * @param $code
     * @param $type
     * @return addressDistrictModel
     */
    public function createDistrict($name, $cityId, $code, $type){
        $district = new addressDistrictModel();
        $district->code = $code;
        $district->type_service = $type;
        $district->name = $name;
        $district->city_id = $cityId;

        $district->save();

        return $district;
    }
}

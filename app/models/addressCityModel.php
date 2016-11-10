<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class addressCityModel
 * @package App\models
 */
class addressCityModel extends Model {

    /**
     * @var string
     */
    protected $table = 'address_city';
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the ward owns with this city
     */
    public function ward()
    {
        return $this->hasMany('App\models\addressWardModel', 'city_id', 'id');
    }

    /**
     * Get the district owns with this city
     */
    public function district()
    {
        return $this->hasMany('App\models\addressDistrictModel', 'city_id', 'id');
    }

    /**
     * Get the address receive associated with address city
     */
    public function addressReceive()
    {
        return $this->hasMany('App\models\addressReceiveModel', 'city_id');
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
     * @param $type
     * @param $code
     * @return addressCityModel
     */
    public function createCity($name, $type, $code){

        $city = new addressCityModel();
        $city->code = $code;
        $city->type_service = $type;
        $city->name = $name;

        $city->save();

        return $city;

    }

    public function getCityByCode($code, $typeService){
        return $this->where('code', $code)
            ->where('type_service', $typeService)->first();
    }

}

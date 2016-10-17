<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class addressCountryModel
 * @package App\models
 */
class addressCountryModel extends Model {

    /**
     * @var string
     */
    protected $table = 'address_country';
    /**
     * @var bool
     */
    public $timestamps = false;


    /**
     * Get the address receive associated with address city
     */
    public function productMadeIn()
    {
        return $this->hasMany('App\models\productModel', 'made_in', 'id');
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

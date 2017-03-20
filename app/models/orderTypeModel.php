<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Kacana\DataTables;

/**
 * Class orderTypeModel
 * @package App\models
 */
class orderTypeModel extends Model  {

    /**
     * @var string
     */
    protected $table = 'order_types';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany('App\models\orderModel', 'order_type', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll(){
        return $this->all();
    }
}

<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class addressReceiveModel
 * @package App\models
 */
class addressReceiveModel extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * @var string
     */
    protected $table = 'address_receive';
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the user associated with product
     */
    public function userAddress()
    {
        return $this->hasMany('App\models\userAddressModel');
    }

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

    /**
     * Get the user associated with product
     */
    public function user()
    {
        return $this->belongsTo('App\models\User', 'user_id');
    }

    /**
     * update information
     *
     * @param id
     * @param options = array()
     * @return true or false
     */
    public function updateItem($id, $options){

        if(isset($options['_token'])){
            unset($options['_token']);
        }
        if(isset($options['_method'])){
            unset($options['_method']);
        }

        $this->where('id', $id)->update($options);
        return addressReceiveModel::find($id);
    }

    /**
     * @param $item
     * @param $default
     * @param $userId
     * @return addressReceiveModel
     */
    public function createItem($userId, $item, $default=0)
    {
        $addReceive = new addressReceiveModel();

        $addReceive->name = $item['name'];
        $addReceive->email = isset($item['email'])?$item['email']:'';
        $addReceive->phone = $item['phone'];
        $addReceive->street = $item['street'];
        $addReceive->city_id = $item['city_id'];
        $addReceive->district_id = $item['district_id'];
        $addReceive->ward_id = isset($item['wardId'])?$item['wardId']:'';
        $addReceive->user_id = $userId;
        if($default)
            $addReceive->default = $default;

        $addReceive->created = date('Y-m-d H:i:s');
        $addReceive->updated = date('Y-m-d H:i:s');

        $addReceive->save();

        return $addReceive;
    }

    /*
     * Update
     * @param array $inputs
     * @return boolean
     */
    /**
     * @param $inputs
     * @return bool
     */
    public function updateAddress($inputs){
        $id = isset($inputs['id']) ? $inputs['id']:'';
        if($id!=''){
            $add_receive = addressReceiveModel::find($id);
            $add_receive->street = $inputs['street'];
            $add_receive->city_id = $inputs['city_id'];
            $add_receive->ward_id = $inputs['ward_id'];
            if($add_receive->save()){
                return true;
            }
        }
        return false;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getAddressByUserId($userId){

        return $this->where(array('user_id'=>$userId))->get();

    }

    /**
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getById($id){
        return $this->find($id);
    }

    public function removeAllDefaultByUserId($userId){
        $this->where('user_id', $userId)->update(['default' => NUll]);
    }

    public function deleteMyAddress($userId, $id){
        $this->where('user_id', $userId)->where('id', $id)->delete();
    }

    public function searchAddressDeliveryByName($name){
        return $this->where('name', 'LIKE', '%'.$name.'%')->get();
    }

    public function searchAddressDeliveryByPhone($phone){
        return $this->where('phone', 'LIKE', '%'.$phone.'%')->get();
    }

}

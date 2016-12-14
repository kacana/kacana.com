<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Kacana\DataTables;

class userAddressModel extends Model {

    protected $table = 'user_address';
    public $timestamps = false;

    /**
     * Get the user that owns the user address.
     */
    public function user()
    {
        return $this->belongsTo('App\models\User', 'user_id');
    }

    /**
     * Get the address receive that owns the user address.
     */
    public function addressReceive()
    {
        return $this->belongsTo('App\models\addressReceiveModel', 'address_id');
    }

    /**
     * - function name : getUserAddress
     * @params: uid
     * @return: list user address
     */
    public function getUserAddress($uid)
    {
        return $this->where('user_id', $uid)->get();
    }

    /**
     * - function name : createItem
     */
    public function createItem($userId, $addressReceiveId)
    {
        $userAddress = new userAddressModel();

        $userAddress->user_id = $userId;
        $userAddress->address_receive_id = $addressReceiveId;
        $userAddress->save();
        return $userAddress;
    }

}

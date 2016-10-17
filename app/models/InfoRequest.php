<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Request;


class InfoRequest extends Model  {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'info_request';
    public $timestamps = false;

    /*
     * create item
     */
    public function createItem($item)
    {
        if(isset($item['_token'])){
            unset($item['_token']);
        }
        $req = new InfoRequest();
        foreach($item as $k=>$v){
            $req->$k = $v;
        }
        $req->created = date('Y-m-d H:i:s');
        $req->updated = date('Y-m-d H:i:s');
        $req->save();
        return $req;
    }

    /**
     * update information
     *
     * @param id
     * @param options = array()
     * @return true or false
     */
    public function updateItem($id, $options){

    }
}

<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

class productPropertiesModel extends Model  {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_properties';
    public $timestamps = false;

    /**
     * Get the tags associated with product
     */
    public function product()
    {
        return $this->belongsTo('App\models\Product');
    }

}

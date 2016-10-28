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
        return $this->belongsTo('App\models\productModel','product_id');
    }

    public function color(){
        return $this->belongsTo('App\models\tagModel', 'tag_color_id');
    }

    public function size(){
        return $this->belongsTo('App\models\tagModel', 'tag_size_id');
    }

    public function gallery(){
        return $this->belongsTo('App\models\productGalleryModel', 'product_gallery_id');
    }

    public function getPropertiesByProductId($productId){
        return $this->where('product_id', $productId)->get();
    }

}

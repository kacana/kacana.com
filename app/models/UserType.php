<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model {

    protected $table = 'user_type';
    public $timestamps = false;

    /**
     * Get the user associated with product
     */
    public function user()
    {
        return $this->hasMany('App\models\User');
    }

    public function scopeShowType($query, $id){
        if($id!="") {
            return $query->where('id', $id)->pluck('name');
        }else{
            return "";
        }

    }
}

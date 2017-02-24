<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

class productImportModel extends Model  {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_import';

    public $timestamps = true;

    /**
     * Get the tags associated with product
     */
    public function properties()
    {
        return $this->belongsTo('App\models\productPropertiesModel', 'property_id');
    }

    public function createItem($propertyId, $quantity, $price, $userId){
        $productImport = new productImportModel();

        $productImport->property_id = $propertyId;
        $productImport->quantity = $quantity;
        $productImport->price = $price;
        $productImport->user_id = $userId;
        $productImport->save();

        return $productImport;
    }

    public function getItem($id){
        return $this->find($id);
    }

    public function deleteItem($id)
    {
        return $this->where('id', $id)->delete();
    }

    public function updateItem($id, $data){
        return $this->where('id', $id)->update($data);
    }
}

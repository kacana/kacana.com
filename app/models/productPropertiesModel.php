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

    public $timestamps = true;

    //Make it available in the json response
    protected $appends = ['nameProperty'];

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

    public function import()
    {
        return $this->hasMany('App\models\productImportModel', 'property_id', 'id');
    }

    public function getPropertiesByProductId($productId){
        return $this->where('product_id', $productId)->get();
    }

    /**
     * @param $productId
     * @param $tagColorId
     * @param $tagSizeId
     * @param $productGalleryId
     * @return bool
     */
    public function createItem($productId, $tagColorId, $tagSizeId, $productGalleryId, $price){

        $data = array(
            'product_id' => $productId,
            'tag_color_id' => $tagColorId,
            'tag_size_id' => $tagSizeId,
            'product_gallery_id' => $productGalleryId,
            'price' => $price
        );

        return $this->insert($data);
    }

    public function getItemById($id)
    {
        return $this->where('id', $id)->first();
    }

    public function updateItem($id, $data)
    {
        return $this->where('id', $id)->update($data);
    }

    public function deleteItem($id)
    {
        return $this->where('id', $id)->delete();
    }

    public function incrementQuantityProductProperty($id, $value = 1){
        return $this->where('id', $id)->increment('quantity', $value);
    }

    public function decrementQuantityProductProperty($id, $value = 1){
        return $this->where('id', $id)->decrement('quantity', $value);
    }

    public function getNamePropertyAttribute(){
        if(isset($this->size))
            return ($this->color->name . ' ' . $this->size);
        return ($this->color->name);
    }

    public function getNewestProduct($offset, $limit){
        $products = $this->with(['product', 'color', 'gallery'])->leftJoin('products', 'products.id', '=', 'product_properties.product_id');
        $products->skip($offset)
            ->take($limit);

        $products->orderBy('product_properties.created_at', 'DESC');
        $products->whereIn('products.status', [KACANA_PRODUCT_STATUS_ACTIVE, KACANA_PRODUCT_STATUS_SOLD_OUT]);
        $products->groupBy('products.id');
        $products->select(['product_properties.*']);
        $results = $products->get();

        return $results ? $results : false;
    }

}

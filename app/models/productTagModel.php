<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Image;
use DB;
use Kacana\DataTables;

/**
 * Class productModel
 * @package App\models
 */
class productTagModel extends Model  {

    protected $table = 'product_tag';

    public $timestamps = false;

    /**
     * @param $tagId
     * @param $productId
     * @param $type
     * @return bool
     */
    public function createItem($tagId, $productId, $type){
        $productTag = new productTagModel();
        $productTag->tag_id = $tagId;
        $productTag->product_id = $productId;
        $productTag->type = $type;

        return $productTag->save();
    }

    /**
     * @param $tagId
     * @param $productId
     * @param $type
     * @return mixed
     */
    public function removeItem($productId, $type, $tagId = false){
        $select = $this->where('product_id', $productId)
            ->where('type', $type);

        if($tagId)
            $select->where('tag_id', $tagId);

        $select->delete();
    }

    /**
     * @param $tagId
     * @param $productId
     * @param $type
     * @return mixed
     */
    public function getItem($tagId, $productId, $type){
        return $this->where('tag_id', $tagId)
            ->where('product_id', $productId)
            ->where('type', $type)
            ->first();
    }
}

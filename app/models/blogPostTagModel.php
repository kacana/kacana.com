<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Image;
use DB;
use Kacana\DataTables;

/**
 * Class blogPostTagModel
 * @package App\models
 */
class blogPostTagModel extends Model  {

    /**
     * @var string
     */
    protected $table = 'blog_post_tag';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param $tagId
     * @param $postId
     * @param int $type
     * @return bool
     */
    public function createItem($tagId, $postId, $type = 1){
        $productTag = new blogPostTagModel();
        $productTag->tag_id = $tagId;
        $productTag->post_id = $postId;
        $productTag->type = $type;

        return $productTag->save();
    }

    /**
     * @param $postId
     * @param int $type
     * @param bool $tagId
     */
    public function removeItem($postId, $type = 1, $tagId = false){
        $select = $this->where('post_id', $postId)
            ->where('type', $type);

        if($tagId)
            $select->where('tag_id', $tagId);

        $select->delete();
    }

    /**
     * @param $tagId
     * @param $postId
     * @param int $type
     * @return mixed
     */
    public function getItem($tagId, $postId, $type = 1){
        return $this->where('tag_id', $tagId)
            ->where('post_id', $postId)
            ->where('type', $type)
            ->first();
    }
}

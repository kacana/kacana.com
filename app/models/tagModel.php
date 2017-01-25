<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Kacana\DataTables;

/**
 * Class TagModel
 * @package App\models
 */
class tagModel extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tags';
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the products associated with tags
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function product()
    {
        return $this->belongsToMany('App\models\productModel', 'product_tag', 'tag_id', 'product_id')->withPivot('type');
    }

    public function postTags()
    {
        return $this->belongsToMany('App\models\blogPostModel', 'blog_tag', 'tag_id', 'post_id')->withPivot('type');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postTag(){
        return $this->hasMany('App\models\blogPostModel','tag_id', 'id');
    }

    /**
     * @return $this
     */
    public function productProperties(){
        return $this->belongsToMany('App\models\productModel')->withPivot('product_gallery_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetailColor(){
        return $this->hasMany('App\models\orderDetailModel','color_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetailSize(){
        return $this->hasMany('App\models\orderDetailModel','size_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productStyle(){
        return $this->hasMany('App\models\productModel','tag_style_id', 'id');
    }

    public function colorProductProperty()
    {
        return $this->hasMany('App\models\productPropertiesModel', 'tag_color_id', 'id');
    }

    public function sizeProductProperty()
    {
        return $this->hasMany('App\models\productPropertiesModel', 'tag_size_id', 'id');
    }

    /**
     * Create tag modal by data array
     *
     * @param $data
     * @return tagModel
     */
    public function createItem($data)
    {
        $tag = new tagModel();

        foreach($data as $key => $value){
            $tag->{$key} = $value;
        }

        $tag->created = date('Y-m-d H:i:s');
        $tag->updated = date('Y-m-d H:i:s');
        $tag->save();

        return $tag;
    }

    /**
     * @param $id
     * @param $data
     * @return \Illuminate\Support\Collection|null|static
     */
    public function updateItem($id, $data)
    {
        $tag = $this->find($id);
        foreach($data as $key => $value){
            $tag->{$key} = $value;
        }
        $tag->updated = date('Y-m-d H:i:s');
        $tag->save();

        return $tag;
    }

    /**
     * generate tag table model
     *
     * @param $request
     * @param $columns
     * @return array
     */
    public function generateTagTable($request, $columns){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );
        $select = $datatables::pluck($columns, 'db');
        // Main query to actually get the data
        $selectData = $this->select($select)
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit']);
        // Data set length
        $recordsFiltered = $selectLength = $this->select($datatables::pluck($columns, 'db'));

        if($where){
            $selectData->whereRaw($where);
            $recordsFiltered->whereRaw($where);
        }

        /*
         * Output
         */
        return array(
            "draw"            => intval( $request['draw'] ),
            "recordsTotal"    => intval( $selectLength->count() ),
            "recordsFiltered" => intval( $recordsFiltered->count() ),
            "data"            => $selectData->get()
        );
    }

    /**
     * get all tag type id
     *
     * @return array|static[]
     */
    public function getAllTagType(){
        $selectData = DB::table('tag_types');

        return $selectData->get();
    }

    /**
     * Get sub tag from parent and tag type
     *
     * @param $tagId
     * @param $relationType
     * @param $status
     * @return array|bool|static[]
     */
    public function getSubTags($tagId, $relationType = false, $status = false ){
        $tagRelations = DB::table('tag_relations');

        $tagRelations->leftJoin('tag_types', 'tag_relations.tag_type_id', '=', 'tag_types.id')
            ->leftJoin('tags', 'tags.id', '=', 'tag_relations.child_id')
            ->where('tag_relations.parent_id','=', $tagId)
            ->groupBy('tags.id');

        if($relationType == TAG_RELATION_TYPE_GROUP && $tagId != 0)
            $tagRelations->orderBy('tags.name', 'ASC');
        else
            $tagRelations->orderBy('tag_relations.tag_order', 'ASC');

        if($relationType)
            $tagRelations->where('tag_relations.tag_type_id','=', $relationType);

        if($status)
            $tagRelations->where('tag_relations.status','=', $status);

        $tagRelations->select(['tag_relations.*', 'tags.*', 'tag_relations.status AS relation_status']);
        $results = $tagRelations->get();

        return $results ? $results : false;
    }

    /**
     * Get number child from parentId
     *
     * @param $tagId
     * @param $relationType
     * @return int
     */
    public function getChildCount($tagId, $relationType)
    {
        $tagRelations = DB::table('tag_relations');

        $tagRelations
            ->where('tag_relations.parent_id','=', $tagId)
            ->where('tag_relations.tag_type_id','=', $relationType);

        return $tagRelations->count();
    }

    /**
     * @param $parentId
     * @param $childId
     * @param $typeId
     * @param $order
     * @return bool
     */
    public function addTagRelation($parentId, $childId, $typeId, $order){
        $tagRelations = DB::table('tag_relations');

        $data = array(
            'parent_id' => $parentId,
            'child_id' => $childId,
            'tag_type_id' => $typeId,
            'tag_order' => $order

        );

        return $tagRelations->insert($data);
    }

    /**
     * remove tag relation
     *
     * @param $tagId
     * @param $typeId
     * @param $parentId
     * @return int
     */
    public function removeTagRelation($tagId, $typeId, $parentId){
        $tagRelations = DB::table('tag_relations');

        return $tagRelations->where('parent_id','=',$parentId)
            ->where('child_id' , '=', $tagId)
            ->where('tag_type_id' , '=', $typeId)
            ->delete();
    }

    /**
     * @param $id
     * @param $parentId
     * @param $typeId
     * @param $imageName
     * @return int
     */
    public function updateImage($id, $parentId, $typeId, $imageName){
        $tagRelations = DB::table('tag_relations');

        return $tagRelations->where('parent_id','=',$parentId)
            ->where('child_id' , '=', $id)
            ->where('tag_type_id' , '=', $typeId)
            ->update(['image'=> $imageName]);
    }

    /**
     * @param $id
     * @param $typeId
     * @param array $updateInfo
     * @return int
     */
    public function updateTagRelationOrder($id, $typeId, array $updateInfo){
        $tagRelations = DB::table('tag_relations');

        return $tagRelations->where('child_id' , '=', $id)
            ->where('tag_type_id' , '=', $typeId)
            ->update($updateInfo);
    }

    /**
     * @param $tagId
     * @param $typeId
     * @return \___PHPSTORM_HELPERS\static|bool
     */
    public function getTagRelation($tagId, $typeId){
        $tagRelations = DB::table('tag_relations');

        $tags = $tagRelations->where('child_id' , '=', $tagId)
            ->where('tag_type_id' , '=', $typeId)
            ->get();

        return ($tags)?$tags[0]:false;
    }

    /**
     * @param $name
     * @param $typeId
     * @return array|bool|static[]
     */
    public function searchTagRelation($name, $typeId){

        $tagRelations = DB::table('tag_relations');

        $tagAddeds = $tagRelations->where('tag_type_id' , '=', $typeId)
            ->get(['child_id']);

        $tagNotIn =[];
        foreach($tagAddeds as $tagAdded)
        {
            $tagNotIn[]=$tagAdded->child_id;
        }

        $tags = DB::table('tags');
        $tags->whereNotIn('tags.id', $tagNotIn)
            ->where('tags.name','like', '%'.$name.'%');

        $results = $tags->get();

        return $results ? $results : false;
    }

    /**
     * @param $id
     * @param bool $relationType
     * @return bool|mixed|static
     */
    public function getTagById($id, $relationType = false){
        $tags = DB::table('tags');

        $tags->leftJoin('tag_relations', 'tags.id', '=', 'tag_relations.child_id')
            ->leftJoin('tag_types', 'tag_relations.tag_type_id', '=', 'tag_types.id')
            ->where('tags.id','=', $id);

        if($relationType)
            $tags->where('tag_relations.tag_type_id','=', $relationType);

        $tags->select('tags.*', 'tag_relations.*', 'tag_types.name AS tag_type_name'  );

        $results = $tags->first();

        return $results ? $results : false;
    }

    public function getTagByIds($ids, $relationType = false){
        $tags = DB::table('tags');

        $tags->leftJoin('tag_relations', 'tags.id', '=', 'tag_relations.child_id')
            ->leftJoin('tag_types', 'tag_relations.tag_type_id', '=', 'tag_types.id')
            ->whereIn('tags.id', $ids)->groupBy('tags.id');
        if($relationType)
            $tags->where('tag_relations.tag_type_id','=', $relationType);

        $tags->select('tags.*', 'tag_relations.*', 'tag_types.name AS tag_type_name'  );

        $results = $tags->get();

        return $results ? $results : false;
    }

    public function getTagByIdsHaveProduct($ids, $relationType = false){
        $tags = DB::table('tags');

        $tags->leftJoin('tag_relations', 'tags.id', '=', 'tag_relations.child_id')
            ->leftJoin('tag_types', 'tag_relations.tag_type_id', '=', 'tag_types.id')
            ->join('product_tag', 'tags.id', '=', 'product_tag.tag_id')
            ->whereIn('tags.id', $ids)->groupBy('tags.id');

        if($relationType)
            $tags->where('tag_relations.tag_type_id','=', $relationType);

        $tags->select('tags.*', 'tag_relations.*', 'tag_types.name AS tag_type_name'  );

        $results = $tags->get();

        return $results ? $results : false;
    }



    /**
     * @param $productId
     * @return array|static[]
     */
    public function getlistTagAddedProduct($productId){
        $tags = DB::table('product_tag');
        $tags->where('product_tag.product_id', '=', $productId);

        return $tags->get();
    }

    /**
     * @param $postId
     * @return array|static[]
     */
    public function getlistTagAddedPost($postId){
        $tags = DB::table('blog_post_tag');
        $tags->where('blog_post_tag.post_id', '=', $postId);

        return $tags->get();
    }

    /**
     * @param $name
     * @param bool $exclude
     * @return mixed
     */
    public function searchTagByName($name, $exclude = false){

        $select = $this->where('tags.name','like', '%'.$name.'%')
                        ->orWhere('tags.id','=', $name);
        if($exclude)
            $select->whereNotIn('tags.id', $exclude);

        $select->orderBy('tags.created', 'DESC');
        $select->take(50);

        return $select->get();
    }

    public function suggestSearchProduct($searchString){
        $query = $this->where('tags.name', 'LIKE', "%".$searchString."%")
            ->join('product_tag', 'tags.id', '=', 'product_tag.tag_id')
            ->join('tag_relations', 'product_tag.tag_id', '=', 'tag_relations.child_id')
            ->join('products', 'products.id', '=', 'product_tag.product_id')
            ->where('tag_relations.status', '=', TAG_RELATION_STATUS_ACTIVE)
            ->where('products.status', '=', KACANA_PRODUCT_STATUS_ACTIVE)
            ->select(['tags.*'])
            ->groupBy('tags.id')
            ->take(10);

        $results = $query->get();

        return $results ? $results : false;
    }

    public function getImageAttribute($value)
    {
        return AWS_CDN_URL.$value;
    }

    public function getAllTagHaveProduct(){

        $query = $this->join('product_tag', 'tags.id', '=', 'product_tag.tag_id')
                        ->join('products', 'products.id', '=', 'product_tag.product_id')
                        ->join('tag_relations', 'product_tag.tag_id', '=', 'tag_relations.child_id')
                        ->where('tag_relations.status', '=', TAG_RELATION_STATUS_ACTIVE)
                        ->where('products.status', '=', KACANA_PRODUCT_STATUS_ACTIVE)
                        ->select(['tag_relations.*', 'tags.*', 'tag_relations.status AS relation_status'])
                        ->groupBy('tags.id');

        $results = $query->get();
        return $results ? $results : false;

    }
}

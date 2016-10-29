<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Image;
use DB;
use Kacana\DataTables;
use Illuminate\Pagination\LengthAwarePaginator;
/**
 * Class productModel
 * @package App\models
 */
class productModel extends Model  {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';
    /**
     * @var bool
     */
    public $timestamps = false;

    //Make it available in the json response
    protected $appends = ['descriptionLazyLoad','mainDiscount'];

    /**
     * Get the tags associated with product
     */
    public function tag()
    {
        return $this->belongsToMany('App\models\tagModel', 'product_tag', 'product_id', 'tag_id')->withPivot('type');
    }

    /**
     * Get the tags associated with product
     */
    public function userLike()
    {
        return $this->belongsToMany('App\models\User', 'user_product_like', 'product_id', 'user_id')->withPivot('created_at');
    }

    /**
     * Get the tags associated with product
     */
    public function madeInCountry()
    {
        return $this->belongsTo('App\models\addressCountryModel', 'made_in');
    }

    /**
     * Get the galleries associated with product
     */
    public function galleries()
    {
        return $this->hasMany('App\models\productGalleryModel', 'product_id', 'id');
    }

    /**
     * Get the galleries associated with product
     */
    public function productView()
    {
        return $this->hasMany('App\models\productViewModel', 'product_id', 'id');
    }

    /**
     * Get the galleries associated with product
     */
    public function properties()
    {
        return $this->belongsToMany('App\models\tagModel', 'product_properties', 'product_id', 'tag_color_id')->withPivot('product_gallery_id', 'tag_size_id');
    }

    /**
     * Get the tags associated with product
     */
    public function style()
    {
        return $this->belongsTo('App\models\tagModel', 'tag_style_id');
    }

    /**
     * Get the address receive associated with address city
     */
    public function detailOrder()
    {
        return $this->hasMany('App\models\orderDetailModel', 'product_id');
    }

    public function productProperties()
    {
        return $this->hasMany('App\models\productPropertiesModel', 'product_id');
    }

    /**
     * create Base product
     *
     * @param $item
     * @return bool
     */
    public function createBaseProduct($item){
        $product = new productModel();
        $product->name = $item['name'];
        $product->price = $item['price'];
        $product->sell_price = $item['sell_price'];
        $product->created = date('Y-m-d H:i:s');
        $product->updated = date('Y-m-d H:i:s');
        return $product->save();
    }

    /*
     * Update Description with image
     *
     * @param string $description
     * @param int $id
     * @param boolean $is_edit
     * @return void
     */
    /**
     * @param $descriptions
     * @param $id
     * @param bool $is_edit
     */
    function updateDescWithImg($descriptions, $id, $is_edit=false)
    {
        preg_match_all('/(http|https):\/\/[^ ]+(\.gif|\.jpg|\.jpeg|\.png)/',$descriptions, $out);
        if($out[0]){
            $count = 1;
            //count item already renamed
            if($is_edit){
                foreach($out[0] as $img){
                    if(strrpos($img, 'tmp')=== FALSE) {
                        $count++;
                    }
                }
            }
            foreach($out[0] as $img){
                if(strrpos($img, 'tmp')!== FALSE) {
                    $img_file = str_replace(LINK_IMAGE . 'images/product/tmp/', '', $img);
                    $path = public_path(PRODUCT_IMAGE . $id);

                    $img_arr = explode('.', strtolower($img_file));

                    $img_name = $img_arr[0];
                    $type = end($img_arr);
                    $new_name = PREFIX_IMG_PRODUCT . str_slug($img_name, "-") . "_" . $count . '.' . $type;

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    } else {
                        chmod($path, 0777);
                    }
                    Image::make($img)->save($path . '/' . $new_name);
                    $descriptions = str_replace('tmp/' . $img_file, $id . '/' . $new_name, $descriptions);
                    unlink(public_path(PRODUCT_IMAGE.'tmp/') . $img_file);
                }
                $count++;
            }
        }
        $this->where('id', $id)->update(array('description' => $descriptions));
    }

    /**
     * @param $id
     * @param $inputs
     */
    public function updateItem($id, $inputs){

        $product = $this->find($id);
        $item['updated'] = date('Y-m-d H:i:s');
        $item['name'] = $inputs['name'];
        $item['short_description'] = $inputs['short_description'];
        $item['meta'] = $inputs['meta'];
        $item['price'] = $inputs['price'];
        $item['sell_price'] = $inputs['sell_price'];
        $item['discount'] = $inputs['price_discount'];
        $item['description'] = $inputs['description'];
        $item['property'] = $inputs['property'];
        $item['tag_style_id'] = $inputs['tag_style_id'];
        $item['made_in'] = $inputs['made_in'];
        $item['source_url'] = $inputs['source_url'];

        $this->where('id', $id)->update($item);
    }

    /**
     * @param $tag
     * @param $limit
     * @return array|static[]
     */
    public function getItemsByTag($tag, $limit){
        $tag_model = new Tag();
        $listChildId = $tag_model->getIdChildsById($tag->id);
        $listChildId[] = $tag->id;

        $query = DB::table('product')
            ->select('product.id', 'product.name', 'product.sell_price', 'product_gallery.image')
            ->join('product_tag', 'product.id', '=', 'product_tag.product_id')
            ->leftJoin('product_gallery', 'product.id', '=', 'product_gallery.product_id')
            ->where('product_gallery.type', PRODUCT_IMAGE_TYPE_MAIN)
            ->whereIn('product_tag.tag_id', $listChildId)
            ->orderBy('created', 'desc')
            ->take($limit)
            ->get();
        return $query;
    }

    /*
     * Get Products By Tag
     *
     * @param int $id
     * @return array
     */
    /**
     * @param $id
     * @return mixed
     */
    public function getProductsByTag($id){
        $tag = new Tag();
        $listChildId = $tag->getIdChildsById($id);
        $listChildId[] = $id;
        $query = Product::join('product_tag', 'product.id', '=', 'product_tag.product_id')
            ->whereIn('product_tag.tag_id', $listChildId)
            ->orderBy('created')
            ->get();
        return $query;
    }

    /**
     * @return mixed
     */
    public function getAllProductForListAdmin(){

        return $this->orderBy('id', 'asc ')->get();
    }



     /*
     * generate product table model
     *
     * @param $request
     * @param $columns
     * @return array
     */
    /**
     * @param $request
     * @param $columns
     * @return array
     */
    public function generateProductTable($request, $columns){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('products')
            ->select($datatables::pluck($columns, 'db'))
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('products')
            ->select($datatables::pluck($columns, 'db'));

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

    public function generateProductTagTable($tags, $request, $columns){
        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('products')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->leftJoin('product_properties', 'product_properties.product_id', '=', 'products.id')
            ->whereIn('product_tag.tag_id', $tags)
            ->orWhereIn('product_properties.tag_color_id', $tags)
            ->orWhereIn('product_properties.tag_size_id', $tags)
            ->orWhereIn('products.tag_style_id', $tags)
            ->groupBy('products.id')
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit']);

         // Data set length
        $recordsFiltered = $selectLength = DB::table('products')
            ->select('products.id')
            ->leftJoin('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->leftJoin('product_properties', 'product_properties.product_id', '=', 'products.id')
            ->whereIn('product_tag.tag_id', $tags)
            ->orWhereIn('product_properties.tag_color_id', $tags)
            ->orWhereIn('product_properties.tag_size_id', $tags)
            ->orWhereIn('products.tag_style_id', $tags);

        if($where){
            $selectData->whereRaw($where);
            $recordsFiltered->whereRaw($where);
        }

        /*
         * Output
         */
        return array(
            "draw"            => intval( $request['draw'] ),
            "recordsTotal"    => intval( $selectLength->distinct()->count('products.id') ),
            "recordsFiltered" => intval( $recordsFiltered->distinct()->count('products.id') ),
            "data"            => $selectData->get()
        );
    }

    public function countSearchProductByTagId($tags){

        $selectData = DB::table('products')
            ->select('products.id')
            ->leftJoin('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->leftJoin('product_properties', 'product_properties.product_id', '=', 'products.id')
            ->whereIn('product_tag.tag_id', $tags)
            ->orWhereIn('product_properties.tag_color_id', $tags)
            ->orWhereIn('product_properties.tag_size_id', $tags)
            ->orWhereIn('products.tag_style_id', $tags);

        return $selectData->distinct()->count('products.id');
    }

    public function searchProductByTagId($tags){

        $selectData = DB::table('products')
            ->leftJoin('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->leftJoin('product_properties', 'product_properties.product_id', '=', 'products.id')
            ->whereIn('product_tag.tag_id', $tags)
            ->orWhereIn('product_properties.tag_color_id', $tags)
            ->orWhereIn('product_properties.tag_size_id', $tags)
            ->orWhereIn('products.tag_style_id', $tags)
            ->groupBy('products.id')
            ->orderBy('products.updated', 'desc');

        return $selectData->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getProductById($id){
        return $this->find($id);
    }

    /**
     * @param $tagIds
     * @param $limit
     * @param int $offset
     * @param int $page
     * @param bool $options
     * @return bool|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductByTagId($tagIds, $limit, $offset = 0, $page = 1, $options = false){
        $select = $this->leftJoin('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->whereIn('product_tag.tag_id', $tagIds)
            ->where('products.status', '=', KACANA_PRODUCT_STATUS_ACTIVE);

        if(!$page)
        {
            $select->skip($offset)
            ->take($limit);
        }

        if(isset($options['sort'])){
            switch ($options['sort']){
                case PRODUCT_LIST_SORT_PRICE_FROM_LOW:
                    $select->orderBy('products.sell_price', 'ASC');
                    break;
                case PRODUCT_LIST_SORT_PRICE_FROM_HEIGHT:
                    $select->orderBy('products.sell_price', 'DESC');
                    break;
                case PRODUCT_LIST_SORT_DISCCOUNT:
                    $select->orderBy('products.discount', 'DESC');
                    break;
                case PRODUCT_LIST_SORT_NEWEST:
                    $select->orderBy('products.updated', 'DESC');
                    break;
                case PRODUCT_LIST_SORT_COMMENT:
                    break;
            }
        }
        else
        {
            $select->orderBy('products.created', 'DESC');
        }

        if(isset($options['product_tag_type_id'])){
            $select->where('product_tag.type', '=', $options['product_tag_type_id'])
                ->leftJoin('tag_relations', 'product_tag.tag_id', '=', 'tag_relations.child_id')
                ->where('tag_relations.tag_type_id', '=', $options['product_tag_type_id'])
                ->where('tag_relations.status', '=', TAG_RELATION_STATUS_ACTIVE);
        }
        else{
            $select->leftJoin('tag_relations', 'product_tag.tag_id', '=', 'tag_relations.child_id')
                ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('product_tag as product_tag_check')
                    ->whereRaw('kacana_product_tag_check.product_id = kacana_products.id')
                    ->join('tag_relations as tag_relation_check', 'product_tag_check.tag_id', '=', 'tag_relation_check.child_id')
                    ->where('tag_relation_check.status', '=', TAG_RELATION_STATUS_ACTIVE)
                    ->where('tag_relation_check.tag_type_id', '=', TAG_RELATION_TYPE_MENU);
            });
        }
        $select->select(['products.*', 'product_tag.*']);
        $select->groupBy('products.id');

        if($page)
            $results = $select->paginate($limit);
        else
            $results = $select->get();
        return $results ? $results : false;
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateProduct($id, $data){
        return $this->updateItem($id, $data);
    }

    /**
     * @param $id
     * @param $image
     * @return mixed
     */
    public function updateImage($id, $image){
        $item['image'] = $image;

        return $this->where('id', $id)->update($item);
    }

    /**
     * @param $id
     * @param $sellPrice
     * @return mixed
     */
    public function updatePrice($id, $sellPrice){
        $item['sell_price'] = $sellPrice;

        return $this->where('id', $id)->update($item);
    }

    /**
     * @param $productId
     * @return int
     */
    public function removeProductProperties($productId){
        $productProperties = DB::table('product_properties');

        return $productProperties->where('product_id','=',$productId)
            ->delete();
    }

    /**
     * @param $productId
     * @param $tagColorId
     * @param $tagSizeId
     * @param $productGalleryId
     * @return bool
     */
    public function addProductProperties($productId, $tagColorId, $tagSizeId, $productGalleryId){
        $productProperties = DB::table('product_properties');

        $data = array(
            'product_id' => $productId,
            'tag_color_id' => $tagColorId,
            'tag_size_id' => $tagSizeId,
            'product_gallery_id' => $productGalleryId

        );

        return $productProperties->insert($data);
    }

    /**
     * @param $offset
     * @param $limit
     * @return bool
     */
    public function getNewestProduct($offset, $limit){

        $products = $this->leftJoin('product_tag', 'products.id', '=', 'product_tag.product_id')
                        ->leftJoin('tag_relations', 'product_tag.tag_id', '=', 'tag_relations.child_id');
        $products->skip($offset)
                ->take($limit);

        $products->orderBy('products.created', 'DESC');
        $products->where('product_tag.type', '=', TAG_RELATION_TYPE_MENU);
        $products->where('tag_relations.tag_type_id', '=', TAG_RELATION_TYPE_MENU);
        $products->where('tag_relations.status', '=', TAG_RELATION_STATUS_ACTIVE);
        $products->groupBy('products.id');
        $products->select(['products.*', 'product_tag.*']);
        $results = $products->get();

        return $results ? $results : false;
    }

    /**
     * @param $offset
     * @param $limit
     * @return bool
     */
    public function getDiscountProduct($offset, $limit){

        $products = $this->leftJoin('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->leftJoin('tag_relations', 'product_tag.tag_id', '=', 'tag_relations.child_id');

        $products->skip($offset)
            ->take($limit);

        $products->orderBy('products.updated', 'DESC');
        $products->where('products.discount', '>', 0);
        $products->where('product_tag.type', '=', TAG_RELATION_TYPE_MENU);
        $products->where('tag_relations.tag_type_id', '=', TAG_RELATION_TYPE_MENU);
        $products->where('tag_relations.status', '=', TAG_RELATION_STATUS_ACTIVE);
        $products->groupBy('products.id');
        $products->select(['products.*', 'product_tag.*']);

        $results = $products->get();

        return $results ? $results : false;
    }

    public function suggestSearchProduct($searchString){


        $query = $this->where('products.name', 'LIKE', "%".$searchString."%")
            ->join('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->leftJoin('tag_relations', 'product_tag.tag_id', '=', 'tag_relations.child_id')
            ->where('tag_relations.status', '=', TAG_RELATION_STATUS_ACTIVE)
            ->where('tag_relations.tag_type_id', '=', TAG_RELATION_TYPE_MENU)
            ->select(['products.*', 'product_tag.*'])
            ->groupBy('products.id')
            ->orderBy('products.updated', 'DESC')
            ->take(10);

        $results = $query->get();

        return $results ? $results : false;
    }

    public function searchProduct($searchString, $limit = 20, $page = 1,  $options = false){

        $path = '/tim-kiem/'.$searchString;

        $query = DB::table('products')->where('products.name', 'LIKE', "%".$searchString."%")
            ->join('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->join('tags', 'tags.id', '=', 'product_tag.tag_id')
            ->join('tag_relations', 'product_tag.tag_id', '=', 'tag_relations.child_id')
            ->where('tag_relations.status', '=', TAG_RELATION_STATUS_ACTIVE)
            ->where('tag_relations.tag_type_id', '=', TAG_RELATION_TYPE_MENU)
            ->select('products.*', 'tags.name as tag_name', 'tags.id as tag_id')->groupBy('products.id');

        $query_1 = DB::table('products')->where('products.name', 'NOT LIKE', "%".$searchString."%")
            ->join('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->join('tags', 'tags.id', '=', 'product_tag.tag_id')
            ->join('tag_relations', 'product_tag.tag_id', '=', 'tag_relations.child_id')
            ->where('tag_relations.status', '=', TAG_RELATION_STATUS_ACTIVE)
            ->where('tag_relations.tag_type_id', '=', TAG_RELATION_TYPE_MENU)
            ->select('products.*', 'tags.name as tag_name', 'tags.id as tag_id')->groupBy('products.id');

        $query_2 = DB::table('products')->where('tags.name', 'LIKE', "%".$searchString."%")
            ->where('products.name', 'NOT LIKE', "%".$searchString."%")
            ->join('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->join('tags', 'tags.id', '=', 'product_tag.tag_id')
            ->select('products.*', 'tags.name as tag_name', 'tags.id as tag_id')->groupBy('products.id');

        $query_2->leftJoin('tag_relations', 'product_tag.tag_id', '=', 'tag_relations.child_id')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('product_tag as product_tag_check')
                    ->whereRaw('kacana_product_tag_check.product_id = kacana_products.id')
                    ->join('tag_relations as tag_relation_check', 'product_tag_check.tag_id', '=', 'tag_relation_check.child_id')
                    ->where('tag_relation_check.status', '=', TAG_RELATION_STATUS_ACTIVE)
                    ->where('tag_relation_check.tag_type_id', '=', TAG_RELATION_TYPE_MENU);
            });

        $searchString = explode(' ', $searchString);

        if(count($searchString))
        {
            $query_1_where = '';
            for($i = 0; $i < count($searchString)-1; $i++){
                $query_1_where .= 'kacana_products.name LIKE "%'.$searchString[$i].'%" OR ';

                $query_2->where('products.name', 'NOT LIKE', "%".$searchString[$i]."%");
            }

            $query_1_where .= 'kacana_products.name LIKE "%'.$searchString[count($searchString)-1].'%"';

            $query_1->whereRaw('('.$query_1_where.')');
            $query_2->where('products.name', 'NOT LIKE', "%".$searchString[count($searchString)-1]."%");

        }


        if(isset($options['sort'])){
            switch ($options['sort']){
                case PRODUCT_LIST_SORT_PRICE_FROM_LOW:
                    $query->orderBy('products.sell_price', 'ASC');
                    $query_1->orderBy('products.sell_price', 'ASC');
                    $query_2->orderBy('products.sell_price', 'ASC');
                    break;
                case PRODUCT_LIST_SORT_PRICE_FROM_HEIGHT:
                    $query->orderBy('products.sell_price', 'DESC');
                    $query_1->orderBy('products.sell_price', 'DESC');
                    $query_2->orderBy('products.sell_price', 'DESC');
                    break;
                case PRODUCT_LIST_SORT_DISCCOUNT:
                    $query->orderBy('products.discount', 'DESC');
                    $query_1->orderBy('products.discount', 'DESC');
                    $query_2->orderBy('products.discount', 'DESC');
                    break;
                case PRODUCT_LIST_SORT_NEWEST:
                    $query->orderBy('products.updated', 'DESC');
                    $query_1->orderBy('products.updated', 'DESC');
                    $query_2->orderBy('products.updated', 'DESC');
                    break;
                case PRODUCT_LIST_SORT_COMMENT:
                    break;
            }
        }
        else
        {
            $query->orderBy('products.updated', 'DESC');
        }

        $query = $query->unionAll($query_1)->unionAll($query_2);
        $querySql = $query->toSql();

        $query = DB::table(DB::raw("(".$querySql." order by updated desc) as a"))->mergeBindings($query);

        $results = $query->get();
        $results_1 = $query->take($limit)->skip($limit * ($page - 1))->get();
        $results = new LengthAwarePaginator($results_1, count($results), $limit, null, ['path'=>$path]);

        return $results ? $results : false;
    }


    public function getDescriptionAttribute($value){
        return str_replace('"/images/product','"'.AWS_CDN_URL.'/images/product', $value);
    }

    public function getDescriptionLazyLoadAttribute($value){
        return str_replace('src="'.AWS_CDN_URL.'/images/product','src="'.AWS_CDN_URL.PRODUCT_IMAGE_PLACE_HOLDER.'" data-original="'.AWS_CDN_URL.'/images/product', $this->attributes['description'] );
    }

    public function getmainDiscountAttribute($value){
        return ($this->attributes['sell_price']*20/100);
    }

    public function getImageAttribute($value)
    {
        return AWS_CDN_URL.$value;
    }

    public function getProductToCreateCsv($limit = 1000, $offset = 0){
        $products = $this->leftJoin('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->where('product_tag.type','=', KACANA_PRODUCT_TAG_TYPE_MENU)->groupBy('products.id');

        if($limit)
        {
            return $products->take($limit)->skip($offset)->get();
        }
        else
            return $products->get();
    }
}

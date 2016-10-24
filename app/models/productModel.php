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
    protected $appends = ['descriptionLazyLoad'];

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
        return $this->belongsToMany('App\models\tagModel', 'product_properties', 'product_id', 'tag_color_id')->withPivot('product_gallery_id', 'tag_size_id', 'color_code');
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
            $select->where('product_tag.type', '=', $options['product_tag_type_id']);
        }

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
     * @param $colorCode
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

        $products = $this->leftJoin('product_tag', 'products.id', '=', 'product_tag.product_id');
        $products->skip($offset)
                ->take($limit);

        $products->orderBy('products.created', 'DESC');
        $products->where('product_tag.type', '=', TAG_RELATION_TYPE_MENU);
        $products->groupBy('products.id');

        $results = $products->get();

        return $results ? $results : false;
    }

    /**
     * @param $offset
     * @param $limit
     * @return bool
     */
    public function getDiscountProduct($offset, $limit){

        $products = $this->leftJoin('product_tag', 'products.id', '=', 'product_tag.product_id');
        $products->skip($offset)
            ->take($limit);

        $products->orderBy('products.updated', 'DESC');
        $products->where('products.discount', '>', 0);
        $products->where('product_tag.type', '=', TAG_RELATION_TYPE_MENU);
        $products->groupBy('products.id');

        $results = $products->get();

        return $results ? $results : false;
    }

    public function suggestSearchProduct($searchString){
        $query = $this->where('products.name', 'LIKE', "%".$searchString."%")
            ->join('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->groupBy('products.id')
            ->take(10);

        $results = $query->get();

        return $results ? $results : false;
    }

    public function searchProduct($searchString, $limit = 20, $page = 1,  $options = false){

        $path = '/tim-kiem/'.$searchString;

        $query = $this->orwhere('products.name', 'LIKE', "%".$searchString."%")
            ->join('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->join('tags', 'tags.id', '=', 'product_tag.tag_id')
            ->select('products.*', 'tags.name as tag_name', 'tags.id as tag_id')->groupBy('products.id');

        $query_1 = DB::table('products')->where('products.name', 'NOT LIKE', "%".$searchString."%")
            ->join('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->join('tags', 'tags.id', '=', 'product_tag.tag_id')
            ->select('products.*', 'tags.name as tag_name', 'tags.id as tag_id')->groupBy('products.id');

        $query_2 = DB::table('products')->where('tags.name', 'LIKE', "%".$searchString."%")
            ->where('products.name', 'NOT LIKE', "%".$searchString."%")
            ->join('product_tag', 'products.id', '=', 'product_tag.product_id')
            ->join('tags', 'tags.id', '=', 'product_tag.tag_id')
            ->select('products.*', 'tags.name as tag_name', 'tags.id as tag_id')->groupBy('products.id');

        $searchString = explode(' ', $searchString);
        if(count($searchString))
        {
            for($i = 0; $i < count($searchString); $i++){
                if($i == 0)
                    $query_1->where('products.name', 'LIKE', "%".$searchString[$i]."%");
                else
                    $query_1->orwhere('products.name', 'LIKE', "%".$searchString[$i]."%");

                $query_2->where('products.name', 'NOT LIKE', "%".$searchString[$i]."%");
            }
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

        $query = $query->union($query_1)->union($query_2);

        $results = $query->get();
        $results_1 = $query->take($limit)->skip($limit * ($page - 1))->get();
        $results = new LengthAwarePaginator($results_1, count($results), $limit, null, ['path'=>$path]);

        return $results ? $results : false;
    }


    public function getDescriptionAttribute($value){
        return str_replace('"/images/product','"'.AWS_CDN_URL.'/images/product', $value);
    }

    public function getDescriptionLazyLoadAttribute($value){
        return str_replace('src="'.AWS_CDN_URL.'/images/product','data-original="'.AWS_CDN_URL.'/images/product', $this->attributes['description'] );
    }

    public function getImageAttribute($value)
    {
        return AWS_CDN_URL.$value;
    }
}

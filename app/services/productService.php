<?php namespace App\services;

use App\models\productModel;
use App\models\productPropertiesModel;
use App\models\productTagModel;
use App\models\tagModel;
use App\models\userProductLikeModel;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;
use Kacana\HtmlFixer;
use Cache;
use App\models\productGalleryModel;
use \Storage;
/**
 * Class productService
 * @package App\services
 */
class productService {

    /**
     * @param $productName
     * @param $productPriceIm
     * @param $productPriceEx
     * @return bool
     */
    public function createBaseProduct($productName, $productPriceIm, $productPriceEx){

        $productModel = new productModel();

        $item = array(
            'name' => $productName,
            'price' => $productPriceIm,
            'sell_price' => $productPriceEx
        );

        return $productModel->createBaseProduct($item);
    }

    /**
     * @return mixed
     */
    public function getAllProductForListAdmin(){
        $productModel = new productModel();
        $products = $productModel->getAllProductForListAdmin();
        return $products;
    }

    /**
     * @param $request
     * @return array
     */
    public function generateProductTable($request){
        $productModel = new productModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'products.id', 'dt' => 0 ),
            array( 'db' => 'products.name', 'dt' => 1 ),
            array( 'db' => 'products.price', 'dt' => 2 ),
            array( 'db' => 'products.sell_price', 'dt' => 3 ),
            array( 'db' => 'products.status', 'dt' => 4 ),
            array( 'db' => 'products.created', 'dt' => 5 ),
            array( 'db' => 'products.updated', 'dt' => 6 )
        );

        $return = $productModel->generateProductTable($request, $columns);
        $statusOptions = [KACANA_PRODUCT_STATUS_ACTIVE, KACANA_PRODUCT_STATUS_INACTIVE];
        if(count($return['data'])) {
            foreach ($return['data'] as &$res) {
                $res->status = $viewHelper->dropdownView('products', $res->id, $res->status, 'status', $statusOptions);
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $request
     * @return array
     */
    public function generateProductTagTable($request){
        $productModel = new productModel();
        $datatables = new DataTables();
        $tagService = new tagService();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'products.id', 'dt' => 0 ),
            array( 'db' => 'products.name', 'dt' => 1 ),
            array( 'db' => 'products.price', 'dt' => 2 ),
            array( 'db' => 'products.sell_price', 'dt' => 3 ),
            array( 'db' => 'products.status', 'dt' => 4 ),
            array( 'db' => 'products.created', 'dt' => 5 ),
            array( 'db' => 'products.updated', 'dt' => 6 )
        );
        $subTag = $tagService->getAllChildTag($request['tagId']);

        $return = $productModel->generateProductTagTable($subTag, $request, $columns);
        $statusOptions = [KACANA_PRODUCT_STATUS_ACTIVE, KACANA_PRODUCT_STATUS_INACTIVE];
        if(count($return['data'])) {
            foreach ($return['data'] as &$res) {
                $res->status = $viewHelper->dropdownView('products', $res->id, $res->status, 'status', $statusOptions);
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $tagId
     * @return int
     */
    public function countSearchProductByTagId($tagId){
        $tagCache = '__count_search_product_by_tag_id__';
        $productModel = new productModel();
        $tagService = new tagService();
        $subTag = $tagService->getAllChildTag($tagId);
        $count = $productModel->countSearchProductByTagId($subTag);
        Cache::tags($tagCache)->put($tagId, $count, '3600');
        return $count;
    }

    /**
     * @param $id
     * @param $userId
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getProductById($id, $userId = 0){
        $productModel = new productModel();
        $userProductLike = new userProductLikeModel();
        $htmlFixer = new HtmlFixer();
        $product = $productModel->getProductById($id);


        if($product->description)
            $product->description = $htmlFixer->getFixedHtml($product->description);
        if($userId)
            $product->isLiked = ($userProductLike->getItem($userId, $product->id))?true:false;

        $this->formatProductProperties($product);

        return $product;
    }


    /**
     * @param $product
     * @return mixed
     */
    public function formatProductProperties(&$product){
        $tagService = new tagService();
        $productGalleryModel = new productGalleryModel();
        $productProperties = $product->properties;
        $properties = array();
        $propertiesSize = array();
        foreach($productProperties as $property){

            if(isset($property->status) && $property->status == KACANA_PRODUCT_STATUS_ACTIVE)
            {
                $pivot = $property->pivot;
                if(!isset($properties[$pivot->tag_color_id]))
                {
                    $properties[$pivot->tag_color_id] = new \stdClass();
                    $properties[$pivot->tag_color_id]->color_name = $property->name;
                    $properties[$pivot->tag_color_id]->color_id = $pivot->tag_color_id;
                    $properties[$pivot->tag_color_id]->color_code = $pivot->color_code;
                    $properties[$pivot->tag_color_id]->product_gallery_id = $pivot->product_gallery_id;
                    $properties[$pivot->tag_color_id]->product_gallery = $productGalleryModel->getById($pivot->product_gallery_id);
                    $properties[$pivot->tag_color_id]->product_gallery_array = ($productGalleryModel->getById($pivot->product_gallery_id))?$productGalleryModel->getById($pivot->product_gallery_id)->toArray():0;

                }

                if(!isset($properties[$pivot->tag_color_id]->size))
                {
                    $properties[$pivot->tag_color_id]->size = [];
                    $properties[$pivot->tag_color_id]->sizeIds = [];
                }

                if($pivot->tag_size_id){
                    $tagSize = $tagService->getTagById($pivot->tag_size_id, TAG_RELATION_TYPE_SIZE);
                    $size = new \stdClass();

                    $size->name = $tagSize->name;
                    $size->id = $tagSize->id;
                    if(!isset($propertiesSize[$pivot->tag_size_id]))
                    {
                        $propertiesSize[$pivot->tag_size_id] = new \stdClass();
                        $propertiesSize[$pivot->tag_size_id]->color = [];
                        $propertiesSize[$pivot->tag_size_id]->colorIds = [];
                    }

                    $propertiesSize[$pivot->tag_size_id]->name = $tagSize->name;
                    $propertiesSize[$pivot->tag_size_id]->id =$pivot->tag_size_id;

                    $colorSize = new \stdClass();
                    $colorSize->name = $property->name;
                    $colorSize->id = $pivot->tag_color_id;

                    array_push($propertiesSize[$pivot->tag_size_id]->color, $colorSize);
                    array_push($propertiesSize[$pivot->tag_size_id]->colorIds, $pivot->tag_color_id);

                    array_push($properties[$pivot->tag_color_id]->size, $size);
                    array_push($properties[$pivot->tag_color_id]->sizeIds, $size->id);
                }
            }
        }
        if(count($propertiesSize))
            $product->propertiesSize = $propertiesSize;
        $product->properties = $properties;

        return $product;
    }

    /**
     * @param $tagId
     * @param $limit
     * @param int $page
     * @param int $userId
     * @param bool $options
     * @return array|bool|static[]
     * @throws \Exception
     */
    public function getProductByTagId($tagId, $limit = 20, $userId = 0, $page = 1, $options = false){

        $productModel = new productModel();
        $userProductLike = new userProductLikeModel();
        $tagService = new tagService();

        if(!$tagId)
            throw new \Exception('Tag id is not available');

        $tagIdList = array();
        $tagIds = $tagService->getAllChildTag($tagId, $tagIdList, $options['product_tag_type_id']);

        //caculate offset from page number
        if($page)
            $offset = ($page-1)*$limit;
        else
            $offset = 0;

        $products = $productModel->getProductByTagId($tagIds, $limit, $offset, $page, $options);

        if(($page && !$products->total()) || !count($products)){
            unset($options['product_tag_type_id']);
            $products = $productModel->getProductByTagId($tagIds, $limit, $offset, $page, $options);
        }


            foreach($products as &$product){
                if($userId)
                    $product->isLiked = ($userProductLike->getItem($userId, $product->id))?true:false;

                $this->formatProductProperties($product);
            }

        return $products;
    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    public function updateProduct($data, $id)
    {
        $productModel = new productModel();
        $productTagModel = new productTagModel();

        $this->updateProductProperties($data, $id);

        $this->updateTagProduct($data, $id, KACANA_PRODUCT_TAG_TYPE_SEARCH);
        $this->updateTagProduct($data, $id, KACANA_PRODUCT_TAG_TYPE_MENU);
        $this->trimImageDesc($data['description'], $id);

        return $productModel->updateItem($id, $data);
    }

    /**
     * @param $description
     * @param $id
     */
    public function trimImageDesc($description, $id){
        $productGallery = new productGalleryModel();
        $productGalleryService = new productGalleryService();

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->strictErrorChecking = false;
        preg_match_all('/src="(.*?)"/', $description, $items);
        $images = $items[1];
        $productImageDesc = $productGallery->getImagesProductByProductId($id, PRODUCT_IMAGE_TYPE_DESC);
        foreach ($productImageDesc as $image)
        {
            if(!in_array($image->image, $images))
            {
                $productGalleryService->deleteImage($image->id);
            }
        }
    }

    /**
     * @param $data
     * @param $productId
     * @param $type
     */
    public function updateTagProduct($data, $productId, $type){
        $productTagModel = new productTagModel();
        $productTagModel->removeItem($productId, $type);
        if(isset($data['productTag_'.$type]) && $data['productTag_'.$type])
            foreach($data['productTag_'.$type] as $tagId)
            {
                $tagCache = '__count_search_product_by_tag_id__';
                Cache::tags($tagCache)->flush();
                $productTagModel->createItem($tagId, $productId, $type);
            }
    }

    /**
     * @param $data
     * @param $id
     */
    public function updateProductProperties($data, $id){
        $productModel = new productModel();
        $productModel->removeProductProperties($id);

        if(isset($data['color']) && count($data['color'])){
            for($i= 0; $i < count($data['color']); $i++){
                if(isset($data['size'][$i]) && count($data['size'][$i])){
                    for($j = 0; $j< count($data['size'][$i]); $j++){
                        $productModel->addProductProperties($id, $data['color'][$i], $data['size'][$i][$j], $data['productGalleryId'][$i]);
                    }
                }
                else{
                    $productModel->addProductProperties($id, $data['color'][$i], 0, $data['productGalleryId'][$i]);
                }
            }
        }
    }

    /**
     * @param $tagId
     * @param $typeId
     * @param $productId
     * @return array
     */
    public function getProductTreeMenu($tagId, $typeId, $productId)
    {
        $tagService = new tagService();
        $productModel = new productModel();

        $tags = $tagService->getSubTagsWithAdminData($tagId, $typeId);

        $tagOfProducts = $productModel->getProductById($productId)->tag;
        $tagProductArray = [];
        foreach($tagOfProducts as $tagOfProduct)
        {
            if($tagOfProduct->pivot->type == KACANA_PRODUCT_TAG_TYPE_MENU)
                array_push($tagProductArray, $tagOfProduct->id);
        }

        foreach($tags as &$tag){
            if(in_array($tag->child_id, $tagProductArray))
            {
                $tag->checked = true;
            }
        }

        return $tags;
    }

    /**
     * @param $productId
     * @param $imageName
     * @return mixed
     */
    public function updateImage($productId, $imageName){
        $productModel = new productModel();
        $productGalleryService = new productGalleryService();

        $product = $productModel->getProductById($productId);

        if($product->getOriginal('image'))
            $productGalleryService->deleteFromS3($product->getOriginal('image'));

        if($imageName)
            $productGalleryService->uploadToS3($imageName);

        return $productModel->updateImage($productId, $imageName);
    }


    /**
     * @param $productId
     */
    public function getProductProperties($productId){
        $productModel = new productModel();

    }

    /**
     * @param $tagId
     * @param $limit
     * @param bool $options
     * @return array|bool|static[]
     * @throws \Exception
     */
    public function getProductRelated($tagId, $limit, $userId, $options = false){
        $options['sort'] = PRODUCT_LIST_SORT_DISCCOUNT;
        $products = $this->getProductByTagId($tagId, $limit, $userId, false, $options);

        foreach($products as &$product)
        {
            $product->url = urlProductDetail($product);
            $product->priceShow = formatMoney($product->sell_price);
            $product->lastPrice = 0;
            if($product->discount)
            {
                $product->discountShow = formatMoney($product->discount);
                $product->lastPrice = formatMoney($product->sell_price - $product->discount);
            }
        }

        return $products;
    }

    /**
     * @param int $userId
     * @param int $offset
     * @param int $limit
     * @return bool
     */
    public function getNewestProduct($userId = 0, $offset = 0, $limit = KACANA_HOMEPAGE_ITEM_PER_TAG ){
        $productModel = new productModel();
        $userProductLike = new userProductLikeModel();
        $products = $productModel->getNewestProduct($offset, $limit);


            foreach($products as &$product){
                if($userId)
                    $product->isLiked = ($userProductLike->getItem($userId, $product->id))?true:false;
                $this->formatProductProperties($product);
            }
        return $products;
    }

    /**
     * @param int $userId
     * @param int $offset
     * @param int $limit
     * @return bool
     */
    public function getDiscountProduct($userId = 0, $offset = 0, $limit = KACANA_HOMEPAGE_ITEM_PER_TAG ){
        $productModel = new productModel();
        $userProductLike = new userProductLikeModel();
        $products = $productModel->getDiscountProduct($offset, $limit);

            foreach($products as &$product){
                if($userId)
                    $product->isLiked = ($userProductLike->getItem($userId, $product->id))?true:false;
                $this->formatProductProperties($product);
            }

        return $products;
    }

    /**
     * @param $searchString
     * @return array|bool
     */
    public function suggestSearchProduct($searchString){
        $productModel = new productModel();
        $tagModel = new tagModel();
        if($searchString)
        {
            $data = array();
            $products = $productModel->suggestSearchProduct($searchString);
            if($products)
                foreach ($products as &$product)
                {
                    $product->slug = str_slug($product->name);
                    $product->priceShow = formatMoney($product->sell_price - $product->discount);
                }
            $data['products'] = $products->toArray();

            $tags = $tagModel->suggestSearchProduct($searchString);
            if($tags)
                foreach ($tags as &$tag)
                {
                    $tag->slug = str_slug($tag->name);
                }
            $data['tags'] = $tags->toArray();

            return $data;
        }
        else
            return false;

    }

    /**
     * @param $searchString
     * @param int $limit
     * @param int $page
     * @param bool $options
     * @return bool|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function searchProduct($searchString, $limit = KACANA_PRODUCT_ITEM_PER_TAG, $page = 1, $options = false){
        $productModel = new productModel();
        $products = $productModel->searchProduct($searchString, $limit, $page, $options);
        foreach ($products as $product)
        {
            $this->formatProductProperties($product);
        }

        return $products;

    }

    /**
     * @param $page
     * @param $type
     * @param $userId
     * @return bool|mixed
     */
    public function loadMoreProductWithType($page, $type, $userId){
        $limit = KACANA_HOMEPAGE_ITEM_PER_TAG;
        $offset = ($page-1)*$limit;
        $results = false;

        if($type == PRODUCT_HOMEPAGE_TYPE_NEWEST)
        {
            $results = $this->getNewestProduct($userId, $offset, $limit);
        }
        elseif($type == PRODUCT_HOMEPAGE_TYPE_DISCOUNT)
        {
            $results = $this->getDiscountProduct($userId, $offset, $limit);
        }

        if(count($results->toArray()))
        {
            return $this->formatProductDataForAjax($results);
        }
        else
            return false;


    }

    /**
     * @param $results
     * @return mixed
     */
    public function formatProductDataForAjax($results){

        foreach ($results as &$item)
        {
            $item->urlProductDetail = urlProductDetail($item);
            $item->sell_price_show = formatMoney($item->sell_price);
            $item->discount_show = formatMoney($item->discount);
            $item->price_after_discount_show = formatMoney($item->sell_price - $item->discount);
            $item->style = $item->style->toArray();
            $item->is_loggin = \Auth::check()?1:0;
            if((count($item->properties)))
            {
                $properties_js = array();
                $i = 0;
                foreach ($item->properties as $property){
                    if($property->product_gallery)
                    {
                        $property->product_gallery->bigimage = $property->product_gallery->image;
                        if($i == 0)
                        {

                            $item->image = $property->product_gallery->getOriginal('image');
                            $property->product_gallery->image = PRODUCT_IMAGE_PLACE_HOLDER;
                        }
                        $i++;
                        array_push($properties_js, $property);
                    }
                }

                $item->properties_js = $properties_js;
            }
            else
                $item->properties_js = 0;
        }
        return $results->toArray();
    }

    public function fixProductPrice(){
        $productModel = new productModel();
        $productGalleryModel = new productGalleryModel();
        $productGalleryService = new productGalleryService();

        $products = productModel::all()->sortByDesc("id");

        foreach ($products as $product){

            if($product->id <= 418)
            {
                $priceUpdate = 0;
                if($product->sell_price > 2000000)
                    $priceUpdate = $product->sell_price + 100000 - 200000;
                elseif($product->sell_price > 1500000)
                    $priceUpdate = $product->sell_price + 100000 - 150000;
                elseif($product->sell_price > 1000000)
                    $priceUpdate = $product->sell_price + 100000 - 100000;
                elseif($product->sell_price > 500000)
                    $priceUpdate = $product->sell_price + 100000 - 50000;
                elseif($product->sell_price > 300000)
                    $priceUpdate = $product->sell_price + 100000 - 30000;
                else
                    $priceUpdate = $product->sell_price + 100000 - 20000;

                $productModel->updatePrice($product->id, $priceUpdate);
            }

            if($product->id <= 418) {
                foreach ($product->galleries as $gallery) {
                    if (Storage::disk('local')->exists($gallery->getOriginal('image')) && filesize(PATH_PUBLIC . $gallery->getOriginal('image'))) {
                        if ($gallery->type == PRODUCT_IMAGE_TYPE_SLIDE) {
                            $thumbPath = str_replace(PATH_PUBLIC, '', $productGalleryService->createThumbnail(PATH_PUBLIC . $gallery->getOriginal('image'), 80, 80, [255, 255, 255]));
                            $productGalleryModel->updateThumb($gallery->id, $thumbPath);
                            $fileContent = Storage::disk('local')->get($thumbPath);
                            Storage::put($thumbPath, $fileContent);
                        }

                        $fileContent = Storage::disk('local')->get($gallery->getOriginal('image'));
                        Storage::put($gallery->getOriginal('image'), $fileContent);
                    }
                }
                if (Storage::disk('local')->exists($product->getOriginal('image')) && PATH_PUBLIC . $product->getOriginal('image')) {
                    $fileContent = Storage::disk('local')->get($product->getOriginal('image'));
                    Storage::put($product->getOriginal('image'), $fileContent);
                }
            }
        }
    }
}



?>
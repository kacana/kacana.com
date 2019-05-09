<?php namespace App\services;

use App\Http\Requests\Request;
use App\models\campaignProductModel;
use App\models\productImportModel;
use App\models\productModel;
use App\models\productPropertiesModel;
use App\models\productTagModel;
use App\models\productViewModel;
use App\models\tagModel;
use App\models\userProductLikeModel;
use App\models\userSocialModel;
use Kacana\DataTables;
use Kacana\Util;
use Kacana\ViewGenerateHelper;
use Kacana\HtmlFixer;
use Cache;
use App\models\productGalleryModel;
use \Storage;
use Carbon\Carbon;
use Shorten;
/**
 * Class productService
 * @package App\services
 */
class productService extends baseService {

    /**
     * @param $productName
     * @param $productPriceIm
     * @param $productPriceEx
     * @return bool
     */
    public function createBaseProduct($productName, $productPriceIm, $productPriceEx){

        $productModel = new productModel();
        $productPropertiesModel = new productPropertiesModel();

        $item = array(
            'name' => $productName,
            'price' => $productPriceIm,
            'sell_price' => $productPriceEx
        );
        $product = $productModel->createBaseProduct($item);
        $productPropertiesModel->createItem($product->id, 0, 0, 0, $product->sell_price);
        return $product;
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
        $campaignProduct = new campaignProductModel();

        $columns = array(
            array( 'db' => 'products.id', 'dt' => 0 ),
            array( 'db' => 'products.name', 'dt' => 1 ),
            array( 'db' => 'products.image', 'dt' => 2 ),
            array( 'db' => 'products.sell_price', 'dt' => 3 ),
            array( 'db' => 'campaign_products.id AS campaign_product', 'dt' => 4 ),
            array( 'db' => 'products.boot_priority', 'dt' => 5 ),
            array( 'db' => 'products.status', 'dt' => 6 ),
            array( 'db' => 'products.updated', 'dt' => 7 )
        );

        $return = $productModel->generateProductTable($request, $columns);

        $statusOptions = [KACANA_PRODUCT_STATUS_ACTIVE, KACANA_PRODUCT_STATUS_INACTIVE, KACANA_PRODUCT_STATUS_SOLD_OUT];
        $bootPriorityOptions = [KACANA_PRODUCT_BOOT_PRIORITY_LEVEL_0,
                                KACANA_PRODUCT_BOOT_PRIORITY_LEVEL_1,
                                KACANA_PRODUCT_BOOT_PRIORITY_LEVEL_2,
                                KACANA_PRODUCT_BOOT_PRIORITY_LEVEL_3,
                                KACANA_PRODUCT_BOOT_PRIORITY_LEVEL_4,
                                KACANA_PRODUCT_BOOT_PRIORITY_LEVEL_5,
                                ];
        if(count($return['data'])) {
            foreach ($return['data'] as &$res) {
                $res->status = $viewHelper->dropdownView('products', $res->id, $res->status, 'status', $statusOptions);
                $res->boot_priority = $viewHelper->dropdownView('products', $res->id, $res->boot_priority, 'boot_priority', $bootPriorityOptions);
                if($res->campaign_product) {
                    $campaignProducts = $campaignProduct->getCampaignByProductId($res->id);

                    foreach ($campaignProducts as &$campaignProduct){
                        $campaignProduct->product_ref = $campaignProduct->productRef;
                        $campaignProduct->product;
                    }

                    $res->campaign_product = $campaignProducts;

                }
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    public function  generateImportProductTable($request){
        $productModel = new productModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'product_import.id AS productImportId', 'dt' => 0 ),
            array( 'db' => 'products.name AS productName', 'dt' => 1 ),
            array( 'db' => 'product_gallery.image AS productImage', 'dt' => 2 ),
            array( 'db' => 'product_import.price', 'dt' => 3 ),
            array( 'db' => 'product_import.quantity', 'dt' => 4 ),
            array( 'db' => 'users.name AS userName', 'dt' => 5 ),
            array( 'db' => 'products.id', 'dt' => 6 ),
            array( 'db' => 'product_import.property_id', 'dt' => 7 ),
            array( 'db' => 'product_import.created_at AS product_import_created_at', 'dt' => 8 ),
            array( 'db' => 'product_import.updated_at AS product_import_updated_at', 'dt' => 9 )
        );

        $return = $productModel->generateImportProductTable($request, $columns);

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $request
     * @return array
     */
    public function generateProductBootTable($request){
        $productModel = new productModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'products.id', 'dt' => 0 ),
            array( 'db' => 'products.name', 'dt' => 1 ),
            array( 'db' => 'products.image', 'dt' => 2 ),
            array( 'db' => 'products.sell_price', 'dt' => 3 ),
            array( 'db' => 'products.discount', 'dt' => 4 ),
            array( 'db' => 'products.updated', 'dt' => 5 ),
            array( 'db' => 'trade_post.id AS trade_post_id', 'dt' => 6 ),
        );

        $return = $productModel->generateProductBootTable($request, $columns);
        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $request
     * @return array
     */
    public function reportDetailTableProductLike($request){
        $userProductLikeModel = new userProductLikeModel();
        $datatables = new DataTables();

        $columns = array(
            array( 'db' => 'users.name AS user_name', 'dt' => 0 ),
            array( 'db' => 'products.name', 'dt' => 1 ),
            array( 'db' => 'user_product_like.product_url', 'dt' => 2 ),
            array( 'db' => 'products.image', 'dt' => 3 ),
            array( 'db' => 'user_product_like.created_at', 'dt' => 4 )
        );

        $return = $userProductLikeModel->reportDetailTableProductLike($request, $columns);

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * @param $request
     * @return array
     */
    public function reportDetailTableProductView($request){
        $productViewModel = new productViewModel();
        $datatables = new DataTables();

        $columns = array(
            array( 'db' => 'product_view.id AS product_view_id', 'dt' => 0 ),
            array( 'db' => 'users.name AS user_name', 'dt' => 1 ),
            array( 'db' => 'products.name', 'dt' => 2 ),
            array( 'db' => 'products.id', 'dt' => 3 ),
            array( 'db' => 'products.image', 'dt' => 4 ),
            array( 'db' => 'product_view.created_at', 'dt' => 5 )
        );

        $return = $productViewModel->reportDetailTableProductView($request, $columns);

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
     * @param $tagId
     * @return int
     */
    public function countProductByTagId($tagId){
        $tagCache = '__count_product_by_tag_id__';
        $productModel = new productModel();
        $tagService = new tagService();
        $subTag = $tagService->getAllChildTag($tagId);
        $count = $productModel->countProductByTagId($subTag);
        Cache::tags($tagCache)->put($tagId, $count, '3600');
        return $count;
    }

    /**
     * @param $id
     * @param $userId
     * @param $status
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getProductById($id, $userId = 0, $status = [KACANA_PRODUCT_STATUS_ACTIVE, KACANA_PRODUCT_STATUS_SOLD_OUT]){
        $productModel = new productModel();
        $userProductLike = new userProductLikeModel();
        $htmlFixer = new HtmlFixer();
        $product = $productModel->getProductById($id, $status);

        if($product->description)
        {
            $product->description = $product->description;
            $product->descriptionLazyLoad = $product->descriptionLazyLoad;
        }

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
        $productPropertiesModel = new productPropertiesModel();
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
     * @param $product
     * @return mixed
     */
    public function formatProductPropertiesWhenSearch(&$product){
        $tagService = new tagService();
        $product->image = AWS_CDN_URL.$product->image;
        $productGalleryModel = new productGalleryModel();
        $productPropertiesModel = new productPropertiesModel();
        $productProperties = $productPropertiesModel->getPropertiesByProductId($product->id);
        $properties = array();
        $propertiesSize = array();
        foreach($productProperties as $property){
            if(isset($property->product->status) && $property->product->status == KACANA_PRODUCT_STATUS_ACTIVE)
            {
                if(!isset($properties[$property->tag_color_id]))
                {
                    $properties[$property->tag_color_id] = new \stdClass();
                    $properties[$property->tag_color_id]->color_name = $property->color->name;
                    $properties[$property->tag_color_id]->color_id = $property->tag_color_id;
                    $properties[$property->tag_color_id]->product_gallery_id = $property->product_gallery_id;
                    $properties[$property->tag_color_id]->product_gallery = $productGalleryModel->getById($property->product_gallery_id);
                    $properties[$property->tag_color_id]->product_gallery_array = ($productGalleryModel->getById($property->product_gallery_id))?$productGalleryModel->getById($property->product_gallery_id)->toArray():0;

                }

                if(!isset($properties[$property->tag_color_id]->size))
                {
                    $properties[$property->tag_color_id]->size = [];
                    $properties[$property->tag_color_id]->sizeIds = [];
                }

                if($property->tag_size_id){
                    $tagSize = $tagService->getTagById($property->tag_size_id, TAG_RELATION_TYPE_SIZE);
                    $size = new \stdClass();

                    $size->name = $tagSize->name;
                    $size->id = $tagSize->id;
                    if(!isset($propertiesSize[$property->tag_size_id]))
                    {
                        $propertiesSize[$property->tag_size_id] = new \stdClass();
                        $propertiesSize[$property->tag_size_id]->color = [];
                        $propertiesSize[$property->tag_size_id]->colorIds = [];
                    }

                    $propertiesSize[$property->tag_size_id]->name = $tagSize->name;
                    $propertiesSize[$property->tag_size_id]->id =$property->tag_size_id;

                    $colorSize = new \stdClass();
                    $colorSize->name = $property->name;
                    $colorSize->id = $property->tag_color_id;

                    array_push($propertiesSize[$property->tag_size_id]->color, $colorSize);
                    array_push($propertiesSize[$property->tag_size_id]->colorIds, $property->tag_color_id);

                    array_push($properties[$property->tag_color_id]->size, $size);
                    array_push($properties[$property->tag_color_id]->sizeIds, $size->id);
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
    public function getProductByTagId($tagId, $limit = 20, $userId = 0, $page = 1, $options = false, $excludeProductIds = false){

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

        $products = $productModel->getProductByTagId($tagIds, $limit, $offset, $page, $options, $excludeProductIds);

        if(($page && !$products->total()) || !count($products)){
            unset($options['product_tag_type_id']);
            $products = $productModel->getProductByTagId($tagIds, $limit, $offset, $page, $options, $excludeProductIds);
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
        $data['description'] = trim($data['description']);

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
     * @param $productId
     * @return bool
     */
    public function updateProductProperties($data, $productId){
        $productModel = new productModel();
        $productPropertiesModel = new productPropertiesModel();

        for($i= 0; $i < count($data['productPropertyId']); $i++){
            $propertyId = $data['productPropertyId'][$i];
            if($propertyId)
            {
                $property = $productPropertiesModel->getItemById($propertyId);
                $updateData = [];
                if($property->quantity > 0)
                {
                    $updateData =[
                        'product_gallery_id' => $data['productGalleryId'][$i],
                        'price' => $data['property_price'][$i]
                    ];
                }
                else
                {
                    $updateData =[
                        'tag_color_id' => $data['color'][$i],
                        'tag_size_id' => $data['size'][$i],
                        'product_gallery_id' => $data['productGalleryId'][$i],
                        'price' => $data['property_price'][$i]
                    ];
                }
                $productPropertiesModel->updateItem($propertyId, $updateData);
            }
            else{
                $productPropertiesModel->createItem($productId, $data['color'][$i], $data['size'][$i], $data['productGalleryId'][$i], $data['property_price'][$i]);
            }
        }
        return true;
    }

    public function deleteProductProperty($propertyId){
        $productPropertiesModel = new productPropertiesModel();
        return $productPropertiesModel->deleteItem($propertyId);
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

        $tagOfProducts = $productModel->getProductById($productId, false)->tag;
        $tagProductArray = [];
        foreach($tagOfProducts as $tagOfProduct)
        {
            if($tagOfProduct->pivot->type == KACANA_PRODUCT_TAG_TYPE_MENU)
                array_push($tagProductArray, $tagOfProduct->id);
        }
        $tagActive = array();
        foreach($tags as $tag){
            if($tag->relation_status)
            {
                if(in_array($tag->child_id, $tagProductArray))
                {
                    $tag->checked = true;
                }
                array_push($tagActive, $tag);
            }
        }

        return $tagActive;
    }

    /**
     * @param $productId
     * @param $imageName
     * @return mixed
     */
    public function updateImage($productId, $imageName){
        $productModel = new productModel();
        $productGalleryService = new productGalleryService();
        $prefixPath = '/images/product/';
        $product = $productModel->getProductById($productId, false);
        $newImageName = $imageName;
        if($product->getOriginal('image'))
            $productGalleryService->deleteFromS3($product->getOriginal('image'));

        if($imageName)
        {
            $imageNameFinal = explode('.', $imageName);
            $typeImage = $imageNameFinal[count($imageNameFinal)-1];
            $newImageName = $prefixPath.str_slug($product->name.' '.time()).'.'.$typeImage;

            $productGalleryService->uploadToS3($imageName, $newImageName);
        }


        return $productModel->updateImage($productId, $newImageName);
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
     * @param array $productIdLoaded
     * @return bool
     */
    public function getNewestProduct($userId = 0, $offset = 0, $limit = KACANA_HOMEPAGE_ITEM_PER_TAG, $productIdLoaded = array()){
        $productModel = new productModel();
        $userProductLike = new userProductLikeModel();
        $products = $productModel->getNewestProduct($offset, $limit, $productIdLoaded);
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

    public function getTagProduct($userId = 0, $offset = 0, $limit = KACANA_HOMEPAGE_ITEM_PER_TAG, $tagId ){
        $productModel = new productModel();
        $userProductLike = new userProductLikeModel();
        $products = $productModel->getProductByTagId([$tagId], $limit, $offset);

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
    public function searchProduct($searchString, $limit = KACANA_PRODUCT_ITEM_PER_TAG, $page = 1, $options = false, $userId){
        $productModel = new productModel();
        $userProductLike = new userProductLikeModel();
        $products = $productModel->searchProduct($searchString, $limit, $page, $options);
        foreach ($products as &$product)
        {
            $this->formatProductPropertiesWhenSearch($product);
            $productTemp = $productModel->getProductById($product->id);
            $product->currentDiscount = $productTemp->currentDiscount;
            $product->isLiked = ($userProductLike->getItem($userId, $product->id))?true:false;
        }

        return $products;

    }

    /**
     * @param $page
     * @param $type
     * @param $tagId
     * @param $productIdLoaded
     * @param $userId
     * @return bool|mixed
     * @throws \Exception
     */
    public function loadMoreProductWithType($page, $type, $tagId, &$productIdLoaded, $userId){
        $limit = KACANA_HOMEPAGE_ITEM_PER_TAG;
        $offset = ($page-1)*$limit;
        $results = false;

        if($type == PRODUCT_HOMEPAGE_TYPE_NEWEST)
        {
            $results = $this->getNewestProduct($userId, $offset, $limit, $productIdLoaded);
        }
        elseif($type == PRODUCT_HOMEPAGE_TYPE_DISCOUNT)
        {
            $results = $this->getDiscountProduct($userId, $offset, $limit);
        }
        elseif ($type == PRODUCT_HOMEPAGE_TYPE_TAG) {
            $results = $this->getProductByTagId($tagId, $limit, $userId, $page, ['product_tag_type_id' => TAG_RELATION_TYPE_MENU], $productIdLoaded);
        }

        if(count($results->toArray()))
        {
            return $this->formatProductDataForAjax($results, $productIdLoaded);
        }
        else
            return false;


    }

    /**
     * @param $results
     * @return mixed
     */
    public function formatProductDataForAjax($results, &$productIdLoaded){

        foreach ($results as &$item)
        {
            array_push($productIdLoaded, $item->id);
            $item->urlProductDetail = urlProductDetail($item);
            $item->sell_price_show = formatMoney($item->sell_price);
            $item->discount_show = formatMoney($item->discount);
            $item->price_after_discount_show = formatMoney($item->sell_price - $item->discount);
            $item->style = $item->style->toArray();
            $item->is_loggin = \Auth::check()?1:0;
            $item->current_discount = $item->currentDiscount;

            if($item->currentDiscount && $item->currentDiscount->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT) {
                $item->current_discount->product_ref = $item->currentDiscount->productRef;
                $item->current_discount->product_ref->urlProductDetail = urlProductDetail($item->current_discount->product_ref);
            }

            if(count($item->properties))
                $item->properties_js = $item->properties;
            else
                $item->properties_js = 0;
        }
        return $results->toArray();
    }

    /**
     * @param $productId
     * @param $userId
     * @param $ip
     */
    public function trackUserProductView($productId, $userId, $ip){
        $productViewModel = new productViewModel();
        $productViewModel->createItem(['product_id' => $productId, 'user_id' => $userId, 'ip' => $ip]);
    }

    /**
     * @param bool $duration
     * @return mixed
     */
    public function getCountProductView($duration = false){
        $productViewModel = new productViewModel();
        return $productViewModel->countProductView($duration);
    }

    /**
     * @param $dateRange
     * @param $type
     * @return mixed
     */
    public function getProductViewReport($dateRange, $type){
        $productViewModel = new productViewModel();
        if(!$dateRange)
        {
            $startTime = Carbon::now()->subDays(KACANA_REPORT_DURATION_DEFAULT);
            $endTime = Carbon::now();

        }else{
            $dateRange = explode(' - ', $dateRange);
            $startTime = $dateRange[0];
            $endTime = Carbon::createFromFormat('Y-m-d', $dateRange[1])->addDay();
        }


        return $productViewModel->reportProductView($startTime, $endTime, $type);
    }

    /**
     * @return bool
     */
    public function createCsvShopping(){
        $productModel = new productModel();
        $products = $productModel->getProductToCreateCsv();

        $path = '/doc/file_shopping.csv';
        if(Storage::disk('local')->exists($path))
            Storage::disk('local')->delete($path);

        $fp = fopen(PATH_PUBLIC.$path, 'w');
        fputcsv($fp, ['id', 'title', 'description', 'brand', 'link', 'image_link', 'availability', 'price', 'condition', 'google_product_category']);
        foreach ($products as $product)
        {
            $link = 'https://kacana.vn/san-pham/' . str_slug($product->name) . '--' . $product->id . '--' . $product->tag_id;
            $image = 'https:'.AWS_CDN_URL.str_replace(' ', '%20',$product->getOriginal('image'));
            $description = strip_tags($product->description);
            fputcsv($fp, [$product->id, $product->name, $description, 'kacana', $link, $image, 'in stock', formatMoney($product->sell_price, ' VND'), 'new', '3032']);
        }

        fclose($fp);

        return true;
    }

    public function createCsvBD(){
        $productModel = new productModel();
        $products = $productModel->getProductToCreateCsv();

        $path = '/doc/file.csv';
        if(Storage::disk('local')->exists($path))
            Storage::disk('local')->delete($path);

        $fp = fopen(PATH_PUBLIC.$path, 'w');
        fputcsv($fp, ['ID', 'ID2', 'Item title', 'Final URL', 'Image URL', 'Item subtitle', 'Item description', 'Item category', 'Price']);
        foreach ($products as $product)
        {
            $link = 'http://kacana.vn/san-pham/' . str_slug($product->name) . '--' . $product->id . '--' . $product->tag_id;
            $image = 'http:'.AWS_CDN_URL.str_replace(' ', '%20',$product->getOriginal('image'));

            fputcsv($fp, [$product->id, $product->tag_id, $product->name, $link, $image, $product->name, $product->short_description, '', formatMoney($product->sell_price, ' VND')]);
        }

        fclose($fp);

        return true;
    }

    public function createCsvFB(){
        $productModel = new productModel();
        $products = $productModel->getProductToCreateCsv();

        $path = '/doc/file_fb.csv';
        if(Storage::disk('local')->exists($path))
            Storage::disk('local')->delete($path);

        $fp = fopen(PATH_PUBLIC.$path, 'w');
        fputcsv($fp, ['id', 'title', 'description', 'availability', 'condition', 'price', 'link', 'image_link', 'brand', 'google_product_category']);

        foreach ($products as $product)
        {
            $link = 'http://kacana.vn/san-pham/' . str_slug($product->name) . '--' . $product->id . '--' . $product->tag_id;
            $image = 'http:'.AWS_CDN_URL.str_replace(' ', '%20',$product->getOriginal('image'));

            fputcsv($fp, [$product->id, $product->name, $product->short_description, 'in stock', 'new', formatMoney($product->sell_price, ' VND'), $link, $image, 'Kacana', 'Apparel & Accessories > Handbags, Wallets & Cases > Handbags']);
        }

        fclose($fp);

        return true;
    }

    /**
     * @param $name
     * @return bool
     */
    public function searchProductByName($name){
        $productModel = new productModel();
        return $productModel->suggestSearchProduct($name);
    }

    public function searchProductByNameForAdmin($name){
        $productModel = new productModel();
        return $productModel->suggestSearchProductForAdmin($name);
    }

    /**
     * @return mixed
     */
    public function getAllProductAvailable(){
        $productModel = new productModel();
        return $productModel->getProductToCreateCsv();
    }

    /**
     * @param $productId
     * @param $descPost
     * @param $images
     * @param $userId
     * @return array
     * @throws \Exception
     */
    public function postProductToFacebook($productId, $descPost, $images, $userId){
        $productModel = new productModel();
        $userSocialModel = new userSocialModel();
        $util = new Util();

        $socialAccount = $userSocialModel->getItem($userId, KACANA_SOCIAL_TYPE_FACEBOOK);
        $facebook = $util->initFacebook();
        $facebook->setDefaultAccessToken($socialAccount->token);

        $product = $productModel->getProductById($productId);
        if(!$product)
            throw new \Exception('BAD Product ID');

        $galleries = $product->galleries;
        $arrayFbMedia = [];

        foreach ($galleries as $gallery)
        {
            if(in_array($gallery->id, $images))
            {
                array_push($arrayFbMedia, $facebook->postPhoto('http:'.AWS_CDN_URL.str_replace(' ', '%20',$gallery->getOriginal('image')), $product->name));
            }
        }
        return $facebook->postFeed($arrayFbMedia, $descPost);
    }

    /**
     * @param $productIds
     * @param $userId
     * @return mixed
     * @throws \Exception
     */
    public function getProductsToBoot($productIds, $userId){
        $productModel = new productModel();
        $util = new Util();

        $google = $util->initGoogle();

        if(!count($productIds))
            throw new \Exception('BAD Product ID');

        $products = $productModel->getProductsToBoot($productIds);

        foreach ($products as &$product)
        {
            $product->list_gallery = $product->galleries;
            $product->list_properties = $product->productProperties->toArray();
            $product->price = 0;
            $product->caption = '👝👜👛'.ucfirst($product->name).'<br>🤑Giá: '.formatMoney($product->sell_price - $product->discount).'<br>🎒👝💼'.$product->short_description;
            $product->sell_price = formatMoney($product->sell_price);
        }
        return $products;

    }

    /**
     * @param $imageIds
     * @return bool
     */
    public function sortProductGallery($imageIds){
        $productGalleryModel = new productGalleryModel();

        for($i = 0; $i < count($imageIds); $i++)
        {
            $order = $i+1;
            $productGalleryModel->updateOrder($imageIds[$i], $order);
        }

        return true;
    }

    public function getProductProperty($id){
        $productPropertiesModel = new productPropertiesModel();
        $property = $productPropertiesModel->getItemById($id);

        if($property)
        {
            $property->colorObject = $property->color;
            $property->sizeObject = $property->size;
            $property->galleryObject = $property->gallery;
            $property->productObject = $property->product;
        }

        return $property;
    }

    public function createImportProduct($propertyId, $quantity, $price, $userId){
        $productImportModel = new productImportModel();
        $this->incrementQuantityProductProperty($propertyId, $quantity);
        return $productImportModel->createItem($propertyId, $quantity, $price, $userId);
    }

    public function updateImportProduct($importId, $quantity, $price, $userId){
        $productImportModel = new productImportModel();
        $productPropertiesModel = new productPropertiesModel();

        $import = $productImportModel->getItem($importId);
        $property = $productPropertiesModel->getItemById($import->property_id);

        $quantityChange = $quantity - $import->quantity;
        $totalQuantity = $property->quantity;

        if($totalQuantity + $quantityChange < 0)
            return false;

        $dataImport = ['quantity'=> $quantity, 'price' => $price];
        $productImportModel->updateItem($importId, $dataImport);
        $this->incrementQuantityProductProperty($property->id, $quantityChange);

        return true;
    }

    public function incrementQuantityProductProperty($propertyId, $value){
        $productPropertyModal = new productPropertiesModel();
        return $productPropertyModal->incrementQuantityProductProperty($propertyId, $value);
    }

    public function decrementQuantityProductProperty($propertyId, $value){
        $productPropertyModal = new productPropertiesModel();
        return $productPropertyModal->decrementQuantityProductProperty($propertyId, $value);
    }

    public function searchProductCampaign($keyword){
        $productModel = new productModel();
        return $productModel->suggestSearchProductForAdmin($keyword);

    }

    public function getProductAjaxById($productId){
        $productModel = new productModel();
        $product = $productModel->getProductById($productId);

        foreach ($product->campaignProduct as &$campaignProduct){
            $campaignProduct->product_ref = $campaignProduct->productRef;
            $campaignProduct->product;
        }

        return $product;

    }
}



?>
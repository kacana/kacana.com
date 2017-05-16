<?php namespace App\Http\Controllers\Client;

use App\services\productService;
use App\services\tagService;
use App\services\trackingService;
use Illuminate\Http\Request;
use App\models\productGalleryModel;

class ProductController extends BaseController {

    /*
     * function mame: productDetail
     * @params: id
     * @return: view
     */
    public function productDetail($domain, $slug, $id, $tagId, Request $request){
        $productService = new productService();
        $tagService = new tagService();
        $productGallery = new productGalleryModel();

        $userId = (\Kacana\Util::isLoggedIn())?$this->_user->id:0;
        try{
            $product = $productService->getProductById($id, $userId);
            $tagIdRelateds = [];
            $product->metaKeyword = $tagService->formatMetaKeyword($product->tag, $tagIdRelateds);

            $data['productRelated'] = [];
            $productRelationIds = [];

            foreach ($tagIdRelateds as $tagIdRelated => $numberProductByTagId)
            {
                $productRelations = $productService->getProductByTagId($tagIdRelated, 100);

                foreach ($productRelations as $productRelation)
                {
                    if(!in_array($productRelation->id, $productRelationIds))
                    {
                        array_push($data['productRelated'], $productRelation);
                        array_push($productRelationIds, $productRelation->id);
                    }

                    if(count($data['productRelated']) > 12)
                        break;
                }

                if(count($data['productRelated']) > 12)
                    break;
            }

            $data['product'] = $product;
            $data['tag'] = $tagService->getTagById($tagId, false);
            $data['productSlide'] = $productGallery->getImagesProductByProductId($id, PRODUCT_IMAGE_TYPE_SLIDE);
            return view('client.product.detail', $data);
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }
    }

    /*
     * function mame: listProduct
     * @params:
     * @return: view
     */
    public function listProductByCate($domain, $slug, $tagId, Request $request){
        $productService = new productService();
        $tagService = new tagService();
        $userId = (\Kacana\Util::isLoggedIn())?$this->_user->id:0;

        try{
            $tag = $request->input('tagId');
            $page = $request->input('page', 1);
            $tag = $tag!="" ? $tag:$tagId;
            $sort = $request->input('sort');
            $options = ['tagId' => $tag, 'sort'=>$sort, 'product_tag_type_id' => TAG_RELATION_TYPE_MENU];

            $limit = KACANA_PRODUCT_ITEM_PER_TAG;
            $data['items'] = $productService->getProductByTagId($tagId, $limit, $userId, $page, $options);
            $tags = $tagService->getTagById($tagId, false);
            $tags->allChilds = $tagService->getAllChildTagHaveProduct($tagId);
            $tagIdRelated = [];
            $tags->tagKeyword = $tagService->formatMetaKeyword($tags->allChilds, $tagIdRelated);

            $data['tag'] = $tags;
            $data['options'] = $options;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return view('client.product.listproduct', $data);
    }

    public function suggestSearchProduct(Request $request){
        $productService = new productService();
        $trackingService = new trackingService();

        $result['ok'] = 0;
        $userId = (\Kacana\Util::isLoggedIn())?$this->_user->id:0;
        try{
            $searchString = $request->input('search', false);
            $data = $productService->suggestSearchProduct($searchString);
            $trackingService->createTrackingSearch($searchString, $userId, $request->ip());
            if($data)
            {
                $result['data'] = $data;
                $result['ok'] = 1;
            }
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }

        return response()->json($result);
    }

    public function loadMoreProductWithType(Request $request){
        $productService = new productService();
        $tagService = new tagService();
        $result['ok'] = 0;

        $type = $request->input('type');
        $page = $request->input('page', 1);

        try{
            $userId = (\Kacana\Util::isLoggedIn())?$this->_user->id:0;
            $data = $productService->loadMoreProductWithType($page, $type, $userId);

            if($data)
            {
                $result['ok'] = 1;
                $result['data'] = $data;
                if(count($data) < KACANA_HOMEPAGE_ITEM_PER_TAG || ($type == PRODUCT_HOMEPAGE_TYPE_NEWEST && $page == 10))
                    $result['stop_load'] = 1;
            }
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }

        return response()->json($result);
    }

    public function postProductToFacebook(Request $request)
    {
        $productService = new productService();

        $productId = $request->input('productId', 0);
        $descPost = $request->input('descPost', 0);
        $images = $request->input('images', 0);

        $result['ok'] = 0;

        try{
            if(\Auth::check()){
                $user = \Auth::user();
                $productService->postProductToFacebook($productId, $descPost, $images, $user->id);
                $result['ok'] = 1;
            }
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }

        return response()->json($result);
    }

    public function trackUserProductView(Request $request){
        $productService = new productService();
        $productId = $request->input('productId');
        $userId = (\Kacana\Util::isLoggedIn())?$this->_user->id:0;
        $result['ok'] = 0;
        try{
            $productService->trackUserProductView($productId, $userId, $request->ip());
            $result['ok'] = 1;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }
        return response()->json($result);
    }
}
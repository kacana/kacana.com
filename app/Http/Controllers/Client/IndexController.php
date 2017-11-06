<?php namespace App\Http\Controllers\Client;

use App\services\productService;
use App\services\shipGhnService;
use App\services\tagService;
use App\services\trackingService;
use App\services\userService;
use Illuminate\Http\Request;
use Kacana\Client\Slack;
use Kacana\Util;
use Pusher;
/**
 * Class IndexController
 * @package App\Http\Controllers\Client
 */
class IndexController extends BaseController {

    /**
     * Show the application welcome screen to the user.
     *
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View

     */

    public function index(Request $request)
    {
        $productService = new productService();
        $tagService = new tagService();

        $limit = KACANA_HOMEPAGE_ITEM_PER_TAG;
        $mainTags = $tagService->getRootTag();
        $data = array();
        foreach($mainTags as $tag){
            $result['tag'] = $tag->name;
            $result['short_desc'] = $tag->short_desc;
            $result['slug'] = str_slug($tag->name. '-');
            $result['tag_id'] = $tag->child_id;
            $result['tag_url'] = '';
            $userId = (\Kacana\Util::isLoggedIn())?$this->_user->id:0;
            $result['products'] = $productService->getProductByTagId($tag->id, $limit, $userId, 1, ['product_tag_type_id'=>TAG_RELATION_TYPE_MENU]);
            $data[] = $result;
        }
        $newestProduct = $productService->getNewestProduct($userId);
        $discountProduct = $productService->getDiscountProduct($userId);
        return view('client.index.index', array('items'=>$data, 'newest' => $newestProduct, 'discount' => $discountProduct));
    }

    public function searchProduct($domain, $searchString, Request $request){
        $productService = new productService();
        $trackingService = new trackingService();
        $result['ok'] = 0;
        $userId = (\Kacana\Util::isLoggedIn())?$this->_user->id:0;
        $page = $request->input('page', 1);
        $limit = $request->input('limit', KACANA_PRODUCT_ITEM_PER_TAG);

        $sort = $request->input('sort');
        $options = ['sort'=>$sort];

        $products = $productService->searchProduct($searchString, $limit, $page, $options, $userId);
        $trackingService->createTrackingSearch($searchString, $userId, $request->ip(), 'sub');
        $result['ok'] = 1;
        $result['products'] = $products;
        $result['search'] = $searchString;
        return view('client.index.search', $result);

    }

    public function facebookWebhook (Request $request){
        \Log::info('Log message', 'test log');
        \Log::info('Log message', print_r($request->all()));
    }


    public function testMessages(){
        return view('client.index.test-messages');
    }
}

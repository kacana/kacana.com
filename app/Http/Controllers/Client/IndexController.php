<?php namespace App\Http\Controllers\Client;

use App\services\campaignService;
use App\services\chatService;
use App\services\productService;
use App\services\tagService;
use App\services\trackingService;
use App\services\webhookService;
use Illuminate\Http\Request;

/**
 * Class IndexController
 * @package App\Http\Controllers\Client
 */
class IndexController extends BaseController
{

    /**
     * Show the application welcome screen to the user.
     *
     * @return \BladeView|bool|\Illuminate\View\View
     */

    public function index()
    {
        $productService = new productService();
        $campaignService = new campaignService();
        $tagService = new tagService();

        $limit = KACANA_HOMEPAGE_ITEM_PER_TAG;
        $mainTags = $tagService->getRootTag();
        $userId = (\Kacana\Util::isLoggedIn()) ? $this->_user->id : 0;
        $data = array();

        $excludeProductIds= array();
        $newestProduct = $productService->getNewestProduct($userId);
        foreach ($newestProduct as $product) {
            array_push($excludeProductIds, $product->id);
        }

        $discountProduct = $productService->getDiscountProduct($userId);

        foreach ($mainTags as $tag) {
            $result['tag'] = $tag->name;
            $result['short_desc'] = $tag->short_desc;
            $result['slug'] = str_slug($tag->name . '-');
            $result['tag_id'] = $tag->child_id;
            $result['tag_url'] = '';
            $result['products'] = $productService->getProductByTagId($tag->id, $limit, $userId, 1, ['product_tag_type_id' => TAG_RELATION_TYPE_MENU], $excludeProductIds);
            $result['sub_tag'] = $tagService->getSubTags($tag->child_id);
            foreach ($result['products'] as $product) {
                array_push($excludeProductIds, $product->id);
            }
            $data[] = $result;
        }

        $currentCampaignDisplay = $campaignService->getCurrentCampaignDisplay();
        $data = array(
            'items' => $data,
            'newest' => $newestProduct,
            'discount' => $discountProduct,
            'campaignDisplay' => $currentCampaignDisplay,
            'productIdsLoaded' => implode(',',$excludeProductIds));
        return view('client.index.index', $data);
    }

    public function searchProduct($domain, $searchString, Request $request)
    {
        $productService = new productService();
        $trackingService = new trackingService();
        $result['ok'] = 0;
        $userId = (\Kacana\Util::isLoggedIn()) ? $this->_user->id : 0;
        $page = $request->input('page', 1);
        $limit = $request->input('limit', KACANA_PRODUCT_ITEM_PER_TAG);

        $sort = $request->input('sort');
        $options = ['sort' => $sort];

        $products = $productService->searchProduct($searchString, $limit, $page, $options, $userId);
        $trackingService->createTrackingSearch($searchString, $userId, $request->ip(), 'sub');
        $result['ok'] = 1;
        $result['products'] = $products;
        $result['search'] = $searchString;
        return view('client.index.search', $result);

    }

    public function facebookWebhook(Request $request)
    {
        $webHookService = new webhookService();
        return $webHookService->facebookWebhook($request->all());
    }


    public function messageSlack(Request $request)
    {
        $params = $request->all();
        $chatMessage = new chatService();
        $chatMessage->createMessagesResponseFromSlack($params);
    }
}

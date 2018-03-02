<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\BranchRequest;
use App\services\campaignService;
use App\services\productService;
use Illuminate\Http\Request;
use Datatables;
use App\models\Branch;


class CampaignController extends BaseController
{

    public function index()
    {
        return view('admin.campaign.index');
    }

    public function generateCampaignTable(Request $request)
    {
        $params = $request->all();
        $campaignService = new campaignService();

        try {
            $return = $campaignService->generateCampaignTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function generateCampaignProductTable($domain, $campaignId, Request $request){
        $params = $request->all();
        $campaignService = new campaignService();

        try {
            $return = $campaignService->generateCampaignProductTable($params, $campaignId);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function createCampaign(Request $request){
        $campaignService = new campaignService();

        $campaignName = $request->input('campaign_name');

        $date = $request->input('apply_date');
        $date = explode(' - ', $date);
        $dateStart = $date[0];
        $dateEnd = $date[1];

        $displayDate = $request->input('display_date');
        $displayDate = explode(' - ', $displayDate);
        $displayDateStart = $displayDate[0];
        $displayDateEnd = $displayDate[1];

        $campaign = $campaignService->createCampaign($campaignName, $displayDateStart, $displayDateEnd, $dateStart, $dateEnd);

        return redirect('/campaign/edit/'.$campaign->id);
    }

    public function validateTimeCampaign(Request $request){
        $campaignService = new campaignService();

        $campaignId = intval($request->input('campaign_id', 0));
        $date = $request->input('date');
        $date = explode(' - ', $date);
        $dateStart = $date[0];
        $dateEnd = $date[1];

        $return = $campaignService->validateTimeCampaign($campaignId, $dateStart, $dateEnd);

        return response()->json($return);
    }

    public function edit($domain, $campaignId, Request $request){
        $campaignService = new campaignService();
        $campaign = $campaignService->getCampaignById($campaignId);

        return view('admin.campaign.edit', array('campaign' => $campaign) );
    }

    public function postEdit(Request $request){
        $campaignService = new campaignService();

        $campaignId = $request->input('campaign_id', 0);
        $campaignName = $request->input('campaign_name', '');
        $campaignDescription = trim($request->input('description', ''));

        $date = $request->input('apply_date');
        $date = explode(' - ', $date);
        $dateStart = $date[0];
        $dateEnd = $date[1];

        $displayDate = $request->input('display_date');
        $displayDate = explode(' - ', $displayDate);
        $displayDateStart = $displayDate[0];
        $displayDateEnd = $displayDate[1];

        $campaignService->updateCampaign($campaignId, $campaignName, $campaignDescription, $displayDateStart, $displayDateEnd, $dateStart, $dateEnd);

        return redirect('/campaign/edit/'.$campaignId);
    }

    public function updateCampaignImage(Request $request){
        $campaignService = new campaignService();

        $return['ok'] = 0;
        $campaignId = $request->input('campaignId');
        $imageName = $request->input('name');
        $type = $request->input('type', KACANA_CAMPAIGN_IMAGE_TYPE_DESCRIPTION);

        try {
            $return['data'] = $campaignService->updateCampaignImage($campaignId, $imageName, $type);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function searchProduct(Request $request){
        $keySearch = $request->input('key');
        $productService = new productService();
        $return['ok'] = 0;

        try {
            $products = $productService->searchProductCampaign($keySearch);
            foreach ($products as &$product)
            {
                $product->campaignProduct;
            }
            $return['data'] = $products;
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function addProductCampaign(Request $request){
        $campaignService = new campaignService();

        $listProductAdded =  $request->input('listProductAdded');
        $discountType =  $request->input('discountType');
        $discountDate =  $request->input('discountDate');
        $discountRef =  $request->input('discountRef');
        $campaignId =  $request->input('campaignId');

        $date = explode(' - ', $discountDate);
        $dateStart = $date[0];
        $dateEnd = $date[1];

        $return['ok'] = 0;

        try {
            $validates =  $campaignService->validateProducts($listProductAdded, $dateStart, $dateEnd);
            if($validates['ok']){
                $campaignService->addProductCampaign($listProductAdded, $campaignId,$discountType, $discountRef, $dateStart, $dateEnd);
                $return['ok'] = 1;
            } else {
                $return['product_added'] = $validates['product_added'];
            }
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function removeCampaignProduct(Request $request){
        $campaignService = new campaignService();
        $campaignProductId =  $request->input('campaignProductId');

        $return['ok'] = 0;

        try {
            $campaignService->removeCampaignProduct($campaignProductId);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }
}
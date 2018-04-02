<?php namespace App\Http\Controllers\Client;

use App\services\campaignService;
use App\services\productService;
use Illuminate\Http\Request;
use App\models\Branch;


class CampaignController extends BaseController
{

    public function index()
    {
        $campaignService = new campaignService();
        $currentCampaignDisplay = $campaignService->getCurrentCampaignDisplay();
        return view('client.campaign.index', array('campaignDisplay' => $currentCampaignDisplay));
    }

    public function detail($domain, $slug, $id, Request $request){
        $campaignService = new campaignService();
        $currentCampaignDisplay = $campaignService->getCurrentCampaignDisplay();
        $campaigns = $campaignService->getCurrentCampaignDisplay($id);
        return view('client.campaign.detail', array('campaignDisplay' => $currentCampaignDisplay, 'campaigns' => $campaigns));
    }
}
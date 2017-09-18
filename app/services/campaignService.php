<?php namespace App\services;

use App\models\campaignGalleryModel;
use App\models\campaignModel;
use App\models\campaignProductModel;
use App\models\campaignRocketModel;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;

class campaignService extends baseService {

    private $_campaignModel;
    private $_campaignRocketModel;
    private $_campaignProductModel;
    private $_campaignGalleryModel;

    public function __construct()
    {
        $this->_campaignModel = new campaignModel();
        $this->_campaignProductModel = new campaignProductModel();
        $this->_campaignRocketModel = new campaignRocketModel();
        $this->_campaignGalleryModel = new campaignGalleryModel();
    }

    public function generateCampaignTable($request){
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'campaigns.id', 'dt' => 0 ),
            array( 'db' => 'campaigns.name', 'dt' => 1 ),
            array( 'db' => 'campaigns.image', 'dt' => 2 ),
            array( 'db' => 'campaigns.display_start_date', 'dt' => 3 ),
            array( 'db' => 'campaigns.display_end_date', 'dt' => 4 ),
            array( 'db' => 'campaigns.start_date', 'dt' => 5 ),
            array( 'db' => 'campaigns.end_date', 'dt' => 6 ),
            array( 'db' => 'campaigns.status', 'dt' => 7 ),
            array( 'db' => 'campaigns.updated_at', 'dt' => 8 )
        );

        $return = $this->_campaignModel->generateCampaignTable($request, $columns);
        $optionStatus = [KACANA_CAMPAIGN_STATUS_ACTIVE, KACANA_CAMPAIGN_STATUS_INACTIVE];

        if(count($return['data'])) {
            foreach ($return['data'] as &$res) {
                $res->status = $viewHelper->dropdownView('campaigns', $res->id, $res->status, 'status', $optionStatus);
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    public function validateTimeCampaign($campaignId, $dateStart, $dateEnd){
        return $this->_campaignModel->validateTimeCampaign($campaignId, $dateStart, $dateEnd);
    }

    public function createCampaign($campaignName, $displayDateStart, $displayDateEnd, $dateStart, $dateEnd){
        return $this->_campaignModel->createCampaign($campaignName, $displayDateStart, $displayDateEnd, $dateStart, $dateEnd);
    }

    public function getCampaignById($id)
    {
        return $this->_campaignModel->getItemById($id);
    }

    public function updateCampaign($id, $campaignName, $description, $displayDateStart, $displayDateEnd, $dateStart, $dateEnd)
    {
        $campaign = $this->_campaignModel->getItemById($id);
        $this->trimImageDesc($campaign->description, $id);
        $description = $this->trimElementDesc($description);
        print_r($description);die;
        return $this->_campaignModel->updateCampaign($id, $campaignName, $description, $displayDateStart, $displayDateEnd, $dateStart, $dateEnd);
    }

    /**
     * @param $description
     * @param $id
     */
    public function trimImageDesc($description, $id){
        $campaignGallery = new campaignGalleryModel();
        $productGalleryService = new productGalleryService();

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->strictErrorChecking = false;
        preg_match_all('/src="(.*?)"/', $description, $items);
        $images = $items[1];
        $campaignImageDesc = $campaignGallery->getImagesCampaignByCampaignId($id, KACANA_CAMPAIGN_IMAGE_TYPE_DESCRIPTION);

        foreach ($campaignImageDesc as $image)
        {
            if(!in_array($image->image, $images))
            {
                $productGalleryService->deleteFromS3($image->getOriginal('image'));
                $campaignGallery->deleteItem($image->id);
            }
        }
    }

    public function updateCampaignImage($id, $imageName, $type)
    {
        $productGalleryService = new productGalleryService();
        $campaign = $this->_campaignModel->getItemById($id);

        $prefixPath = '/images/campaign/';
        $imageNameFinal = explode('.', $imageName);
        $typeImage = $imageNameFinal[count($imageNameFinal) - 1];

        $newImageName = $prefixPath . str_slug($campaign->name . ' ' . crc32($imageName)) . '.' . $typeImage;
        $productGalleryService->uploadToS3($imageName, $newImageName);

        if ($type == KACANA_CAMPAIGN_IMAGE_TYPE_MAIN_IMAGE) {
            if ($campaign->getOriginal('image'))
                $productGalleryService->deleteFromS3($campaign->getOriginal('image'));

            return $this->_campaignModel->updateCampaignImage($id, $newImageName);
        } else {
            return $this->_campaignGalleryModel->addCampaignImage($id, $newImageName);
        }
    }
}



?>
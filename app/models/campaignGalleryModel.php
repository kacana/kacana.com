<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

class campaignGalleryModel extends Model {

    protected $table = 'campaign_gallery';

    public function campaign()
    {
        return $this->belongsTo('App\models\campaignModel');
    }

    public function addCampaignImage($campaignId, $nameImage, $thumb = '', $type = KACANA_CAMPAIGN_IMAGE_TYPE_DESCRIPTION){
        $campaignGallery = new campaignGalleryModel();
        $campaignGallery->campaign_id = $campaignId;
        $campaignGallery->image = $nameImage;
        $campaignGallery->thumb = $thumb;
        $campaignGallery->type = $type;
        $campaignGallery->save();

        return $campaignGallery;
    }

    public function getImageAttribute($value)
    {
        return AWS_CDN_URL.$value;
    }

    public function getImagesCampaignByCampaignId($id, $type){
        $images =  $this->where('campaign_id',$id)->orderBy('id','asc');

        if($type)
        {
            $images->where('type', $type);
        }

        return $images->get();
    }

    public function deleteItem($id){
        return $this->find($id)->delete();
    }

}

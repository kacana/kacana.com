<?php namespace App\models;

use Carbon\Carbon;
use function foo\func;
use Illuminate\Database\Eloquent\Model;
use Kacana\DataTables;
use DB;

class campaignModel extends baseModel {

    protected $table = 'campaigns';

    public function campaignProduct()
    {
        return $this->hasMany('App\models\campaignProductModel', 'campaign_id', 'id')->orderby('campaign_products.start_date', 'asc');
    }

    public function campaignProductAvailable()
    {
        $currentDay = Carbon::now();

        return $this->hasMany('App\models\campaignProductModel', 'campaign_id', 'id')->orderby('campaign_products.start_date', 'asc')
                            ->where('campaign_products.end_date', '>=', $currentDay);
    }

    public function campaignRocket()
    {
        return $this->hasMany('App\models\campaignRocketModel', 'campaign_id', 'id');
    }

    public function generateCampaignTable($request, $columns){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        $arraySelect = $datatables::pluck($columns, 'db');

        // Main query to actually get the data
        $selectData = DB::table('campaigns')
            ->select($arraySelect)
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength =  DB::table('campaigns')
            ->select($arraySelect)
            ->orderBy($order['field'], $order['dir']);

        if($where){
            $selectData->whereRaw($where);
            $recordsFiltered->whereRaw($where);
        }

        /*
         * Output
         */
        return array(
            "draw"            => intval( $request['draw'] ),
            "recordsTotal"    => count( $selectLength->get() ),
            "recordsFiltered" => count( $recordsFiltered->get() ),
            "data"            => $selectData->get()
        );
    }

    public function validateTimeCampaign($campaignId, $dateStart, $dateEnd){

        $campaign = $this->where(function ($query) use ($dateStart, $dateEnd){
            $query->where(function ($query) use ($dateStart){
                $query->where('start_date', '<=', $dateStart)
                    ->where('end_date', '>=', $dateStart);
            })->orWhere(function ($query) use ($dateEnd){
                $query->where('start_date', '<=', $dateEnd)
                    ->where('end_date', '>=', $dateEnd);
            });
        });

        if($campaignId)
            $campaign = $campaign->where('id','!=', $campaignId);

        return $campaign->get();
    }

    public function createCampaign($campaignName, $displayDateStart, $displayDateEnd, $dateStart, $dateEnd){
        $campaign = new campaignModel();
        $campaign->name = $campaignName;
        $campaign->display_start_date = $displayDateStart;
        $campaign->display_end_date = $displayDateEnd;
        $campaign->start_date = $dateStart;
        $campaign->end_date = $dateEnd;
        $campaign->status = KACANA_CAMPAIGN_STATUS_INACTIVE;

        $campaign->save();

        return $campaign;
    }

    public function getItemById($id){
        return $this->find($id);
    }

    public function updateCampaign($id, $campaignName, $description, $displayDateStart, $displayDateEnd, $dateStart, $dateEnd){

        $item['name'] = $campaignName;
        $item['description'] = $description;
        $item['display_start_date'] = $displayDateStart;
        $item['display_end_date'] = $displayDateEnd;
        $item['start_date'] = $dateStart;
        $item['end_date'] = $dateEnd;

        return $this->where('id', $id)->update($item);
    }

    public function updateCampaignImage($id, $image){
        $item['image'] = $image;
        return $this->where('id', $id)->update($item);
    }

    public function getImageAttribute($value)
    {
        return AWS_CDN_URL.$value;
    }

    public function getCurrentCampaignDisplay($campaignId = false){
        $currentDay = Carbon::now();
        $campaign = $this->where('display_start_date', '<=', $currentDay)->where('display_end_date', '>=', $currentDay)->where('status', KACANA_CAMPAIGN_STATUS_ACTIVE);
        if($campaignId)
            $campaign->where('id', $campaignId);

        return $campaign->get();
    }

    public function getAll(){
        return $this->where('status', KACANA_CAMPAIGN_STATUS_ACTIVE)->get();
    }
}

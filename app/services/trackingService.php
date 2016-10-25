<?php namespace App\services;

use App\models\baseModel;
use App\models\trackingSearchModel;
use Carbon\Carbon;
/**
 * Class baseService
 * @package App\services
 */
class trackingService {


    public $_trackingSeachModel;

    /**
     * baseService constructor.
     */
    public function __construct()
    {
        $this->_trackingSeachModel = new trackingSearchModel();
    }

    /**
     * @param $id
     * @param $status
     * @return mixed
     */
    public function changefieldDropdown($id, $status, $field, $table){
        $baseModel = new baseModel();
        return $baseModel->changefieldDropdown($id, $status, $field, $table);
    }

    public function getCountTrackingSearch($duration = false){
        return $this->_trackingSeachModel->countTrackingSearch($duration);
    }

    public function getTrackingSearchReport($dateRange, $type){
        if(!$dateRange)
        {
            $startTime = Carbon::now()->subDays(KACANA_REPORT_DURATION_DEFAULT);
            $endTime = Carbon::now();

        }else{
            $dateRange = explode(' - ', $dateRange);
            $startTime = $dateRange[0];
            $endTime = Carbon::createFromFormat('Y-m-d', $dateRange[1])->addDay();
        }


        return $this->_trackingSeachModel->reportTrackingSearch($startTime, $endTime, $type);
    }

    public function createTrackingSearch($keyword, $userId, $ip, $type = 'sug'){
        return $this->_trackingSeachModel->createItem(['keyword'=>$keyword, 'user_id'=>$userId, 'ip'=>$ip, 'type'=>$type]);
    }

}



?>
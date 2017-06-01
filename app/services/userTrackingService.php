<?php namespace App\services;

use App\models\userTracking;
use App\models\userTrackingHistory;

class userTrackingService extends baseService {

    protected $_userTrackingModel;

    protected $_userTrackingHistoryModel;

    public function __construct()
    {
        $this->_userTrackingModel = new userTracking();
        $this->_userTrackingHistoryModel = new userTrackingHistory();
    }

    public function createUserTracking($data){
        return $this->_userTrackingModel->createItem($data);
    }

    public function createUserTrackingHistory($data){
        return $this->_userTrackingHistoryModel->createItem($data);
    }

    public function getTrackingHistoryInformation($idTracking){
        $trackingHistory = $this->_userTrackingHistoryModel->getItem($idTracking);
        $trackingHistory->ip = $this->getIpInformation($trackingHistory->ip);
        $trackingHistory->user_agent = $this->parserUserAgent($trackingHistory->user_agent);
        return $trackingHistory;
    }

}

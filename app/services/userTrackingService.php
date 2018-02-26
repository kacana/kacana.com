<?php namespace App\services;

use App\models\userTracking;
use App\models\userTrackingHistory;
use Kacana\DataTables;
use Carbon\Carbon;

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

    public function getUserTracking($trackingId = 0){
        $userTracking = $this->_userTrackingModel->getItem($trackingId);
        $userTracking->ip = $this->getIpInformation($userTracking->ip);
        $userTracking->user_agent = $this->parserUserAgent($userTracking->user_agent);
        return $userTracking;
    }

    public function getUserTrackingHistory($trackingHistoryId = 0){
        $userTracking = $this->_userTrackingHistoryModel->getItem($trackingHistoryId);
        $userTracking->ip = $this->getIpInformation($userTracking->ip);
        $userTracking->user_agent = $this->parserUserAgent($userTracking->user_agent);
        return $userTracking;
    }

    public function getCountTracking($duration = false){
        return $this->_userTrackingModel->countTracking($duration);
    }

    public function reportDetailTableUserTracking($request){
        $datatables = new DataTables();

        $columns = array(
            array( 'db' => 'user_tracking.id', 'dt' => 0 ),
            array( 'db' => 'user_tracking.url', 'dt' => 1 ),
            array( 'db' => 'user_tracking.referer', 'dt' => 2 ),
            array( 'db' => 'user_tracking.ip', 'dt' => 3 ),
            array( 'db' => 'user_tracking.created_at', 'dt' => 4 )
        );

        $return = $this->_userTrackingModel->reportDetailTableUserTracking($request, $columns);

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    public function reportChartUserTracking($dateRange, $type){
        if(!$dateRange)
        {
            $startTime = Carbon::now()->subDays(KACANA_REPORT_DURATION_DEFAULT);
            $endTime = Carbon::now();

        }else{
            $dateRange = explode(' - ', $dateRange);
            $startTime = $dateRange[0];
            $endTime = Carbon::createFromFormat('Y-m-d', $dateRange[1])->addDay();
        }


        return $this->_userTrackingModel->reportUserTracking($startTime, $endTime, $type);
    }

    public function generateUserTrackingHistoryTable($request, $trackingId){
        $datatables = new DataTables();

        $columns = array(
            array( 'db' => 'user_tracking_history.id', 'dt' => 0 ),
            array( 'db' => 'user_tracking_history.url', 'dt' => 1 ),
            array( 'db' => 'user_tracking_history.referer', 'dt' => 2 ),
            array( 'db' => 'user_tracking_history.ip', 'dt' => 3 ),
            array( 'db' => 'user_tracking_history.type_call', 'dt' => 4 ),
            array( 'db' => 'user_tracking_history.created_at', 'dt' => 5 )
        );

        $return = $this->_userTrackingModel->generateUserTrackingHistoryTable($request, $columns, $trackingId);

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }
}

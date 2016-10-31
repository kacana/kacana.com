<?php namespace App\services;

use App\models\baseModel;
use App\models\trackingSearchModel;
use Carbon\Carbon;
use Kacana\DataTables;
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

    public function reportDetailTableTrackingSearch($request){
        $trackingSearchModel = new trackingSearchModel();
        $datatables = new DataTables();
//        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'tracking_search.id', 'dt' => 0 ),
            array( 'db' => 'tracking_search.keyword', 'dt' => 1 ),
            array( 'db' => 'users.id', 'dt' => 2 ),
            array( 'db' => 'users.name', 'dt' => 3 ),
            array( 'db' => 'tracking_search.ip', 'dt' => 4 ),
            array( 'db' => 'tracking_search.type', 'dt' => 5 ),
            array( 'db' => 'tracking_search.created_at', 'dt' => 6 ),
            array( 'db' => 'tracking_search.updated_at', 'dt' => 7 )
        );

        $return = $trackingSearchModel->reportDetailTableTrackingSearch($request, $columns);
//        $statusOptions = [KACANA_PRODUCT_STATUS_ACTIVE, KACANA_PRODUCT_STATUS_INACTIVE];
//        if(count($return['data'])) {
//            foreach ($return['data'] as &$res) {
//                $res->status = $viewHelper->dropdownView('products', $res->id, $res->status, 'status', $statusOptions);
//            }
//        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

}



?>
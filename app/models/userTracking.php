<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Kacana\DataTables;
use DB;

class userTracking extends Model {

    protected $table = 'user_tracking';
    public $timestamps = true;

    public function createItem($data){
        $userTracking = new userTracking();

        foreach($data as $key => $value){
            $userTracking->{$key} = $value;
        }

        $userTracking->save();

        return $userTracking;
    }

    public function countTracking($duration = false){
        $date = Carbon::now()->subDays($duration);
        if($duration === false)
            return $this->count();
        else
            return $this->where('created_at', '>=', $date)->count();
    }

    public function reportDetailTableUserTracking($request, $columns){

        $datatables = new DataTables();
        $type = $request['type'];
        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );
        $dateSelected = $request['dateSelected'];

        $typeWhere = DB::raw('DATE_FORMAT(kacana_user_tracking.created_at, "%Y-%m-%d")');

        if($type == 'month') {
            $dateSelected = substr($dateSelected,0,7);
            $typeWhere =DB::raw('DATE_FORMAT(kacana_user_tracking.created_at, "%Y-%m")');
        }
        elseif($type == 'year') {
            $dateSelected = substr($dateSelected,0,4);
            $typeWhere = DB::raw('DATE_FORMAT(kacana_user_tracking.created_at, "%Y")');
        }
        // Main query to actually get the data
        $selectData = DB::table('user_tracking')
            ->select($datatables::pluck($columns, 'db'))
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit'])
            ->where($typeWhere,'=',$dateSelected);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('user_tracking')
            ->select($datatables::pluck($columns, 'db'))
            ->where($typeWhere,'=',$dateSelected);

        if($where){
            $selectData->whereRaw($where);
            $recordsFiltered->whereRaw($where);
        }

        /*
         * Output
         */
        return array(
            "draw"            => intval( $request['draw'] ),
            "recordsTotal"    => intval( $selectLength->distinct()->count('*')),
            "recordsFiltered" => intval( $recordsFiltered->distinct()->count('*')),
            "data"            => $selectData->get()
        );
    }

    public function reportUserTracking($startTime, $endTime, $type = 'date'){
        $userTrackingReport =  $this->where('created_at', '>=', $startTime)
            ->where('created_at', '<=', $endTime);
        if($type == 'day')
            $userTrackingReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        elseif($type == 'month')
            $userTrackingReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        elseif($type == 'year')
            $userTrackingReport->select('*',DB::raw('DATE_FORMAT(created_at, "%Y") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        return $userTrackingReport->get();
    }

    public function getItem($id){
        return $this->find($id);
    }

    public function generateUserTrackingHistoryTable($request, $columns, $trackingId)
    {
        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('user_tracking_history')
            ->select($datatables::pluck($columns, 'db'))
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit'])
            ->where('session_id','=', $trackingId);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('user_tracking_history')
            ->select($datatables::pluck($columns, 'db'))
            ->where('session_id','=', $trackingId);

        if($where){
            $selectData->whereRaw($where);
            $recordsFiltered->whereRaw($where);
        }

        /*
         * Output
         */
        return array(
            "draw"            => intval( $request['draw'] ),
            "recordsTotal"    => intval( $selectLength->distinct()->count('*')),
            "recordsFiltered" => intval( $recordsFiltered->distinct()->count('*')),
            "data"            => $selectData->get()
        );
    }
}

<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Carbon\Carbon;
use Kacana\DataTables;

class trackingSearchModel extends Model  {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tracking_search';
    public $timestamps = true;

    /**
     * Create product view by data array
     *
     * @param $data
     * @return tagModel
     */
    public function createItem($data)
    {
        $trackingSearch = new trackingSearchModel();

        foreach($data as $key => $value){
            $trackingSearch->{$key} = $value;
        }
        $trackingSearch->save();

        return $trackingSearch;
    }

    public function countTrackingSearch($duration = false){
        $date = Carbon::now()->subDays($duration);
        if($duration === false)
            return $this->count();
        else
            return $this->where('created_at', '>=', $date)->count();
    }

    public function reportTrackingSearch($startTime, $endTime, $type = 'date')
    {
        $trackingSearchReport =  $this->where('created_at', '>=', $startTime)
            ->where('created_at', '<=', $endTime);
        if($type == 'day')
            $trackingSearchReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        elseif($type == 'month')
            $trackingSearchReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        elseif($type == 'year')
            $trackingSearchReport->select('*',DB::raw('DATE_FORMAT(created_at, "%Y") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        return $trackingSearchReport->get();
    }

    public function reportDetailTableTrackingSearch($request, $columns){

        $datatables = new DataTables();
        $type = $request['type'];
        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );
        $dateSelected = $request['dateSelected'];

        if($type == 'day')
            $typeWhere = DB::raw('DATE_FORMAT(kacana_tracking_search.created_at, "%Y-%m-%d")');
        elseif($type == 'month') {
            $dateSelected = substr($dateSelected,0,7);
            $typeWhere =DB::raw('DATE_FORMAT(kacana_tracking_search.created_at, "%Y-%m")');
        }
        elseif($type == 'year') {
            $dateSelected = substr($dateSelected,0,4);
            $typeWhere = DB::raw('DATE_FORMAT(kacana_tracking_search.created_at, "%Y")');
        }
        // Main query to actually get the data
        $selectData = DB::table('tracking_search')
            ->select($datatables::pluck($columns, 'db'))
            ->leftjoin('users', 'tracking_search.user_id', '=', 'users.id')
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit'])
            ->where($typeWhere,'=',$dateSelected);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('tracking_search')
            ->select($datatables::pluck($columns, 'db'))
            ->leftjoin('users', 'tracking_search.user_id', '=', 'users.id')
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

}

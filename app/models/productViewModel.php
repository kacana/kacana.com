<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Carbon\Carbon;
use Kacana\DataTables;

class productViewModel extends Model  {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_view';
    public $timestamps = true;

    /**
     * Get the tags associated with product
     */
    public function product()
    {
        return $this->belongsTo('App\models\Product');
    }

    /**
     * Create product view by data array
     *
     * @param $data
     * @return tagModel
     */
    public function createItem($data)
    {
        $productView = new productViewModel();

        foreach($data as $key => $value){
            $productView->{$key} = $value;
        }
        $productView->save();

        return $productView;
    }

    public function countProductView($duration = false){
        $date = Carbon::now()->subDays($duration);
        if($duration === false)
            return $this->count();
        else
            return $this->where('created_at', '>=', $date)->count();
    }

    public function reportProductView($startTime, $endTime, $type = 'date')
    {
        $productViewReport =  $this->where('created_at', '>=', $startTime)
            ->where('created_at', '<=', $endTime);
        if($type == 'day')
            $productViewReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        elseif($type == 'month')
            $productViewReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        elseif($type == 'year')
            $productViewReport->select('*',DB::raw('DATE_FORMAT(created_at, "%Y") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        return $productViewReport->get();
    }

    public function reportDetailTableProductView($request, $columns){

        $datatables = new DataTables();
        $type = $request['type'];
        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );
        $dateSelected = $request['dateSelected'];

        if($type == 'day')
            $typeWhere = DB::raw('DATE_FORMAT(kacana_product_view.created_at, "%Y-%m-%d")');
        elseif($type == 'month') {
            $dateSelected = substr($dateSelected,0,7);
            $typeWhere =DB::raw('DATE_FORMAT(kacana_product_view.created_at, "%Y-%m")');
        }
        elseif($type == 'year') {
            $dateSelected = substr($dateSelected,0,4);
            $typeWhere = DB::raw('DATE_FORMAT(kacana_product_view.created_at, "%Y")');
        }
        // Main query to actually get the data
        $selectData = DB::table('product_view')
            ->select($datatables::pluck($columns, 'db'))
            ->leftjoin('users', 'product_view.user_id', '=', 'users.id')
            ->join('products', 'product_view.product_id', '=', 'products.id')
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit'])
            ->where($typeWhere,'=',$dateSelected);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('product_view')
            ->select($datatables::pluck($columns, 'db'))
            ->leftjoin('users', 'product_view.user_id', '=', 'users.id')
            ->join('products', 'product_view.product_id', '=', 'products.id')
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
            "recordsTotal"    => intval( $selectLength->distinct()->count('product_view.id') ),
            "recordsFiltered" => intval( $recordsFiltered->distinct()->count('product_view.id') ),
            "data"            => $selectData->get()
        );
    }
}

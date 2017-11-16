<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Kacana\DataTables;
use Carbon\Carbon;

/**
 * Class orderFromModel
 * @package App\models
 */
class orderFromModel extends Model  {

    /**
     * @var string
     */
    protected $table = 'order_froms';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\models\User', 'user_id');
    }

    /**
     * @param $item
     * @return orderModel
     */
    public function createItem($title, $description, $userId){
        $orderFrom = new orderFromModel();
        $orderFrom->name = $title;
        $orderFrom->description = $description;
        $orderFrom->user_id = $userId;

        $orderFrom->save();

        return $orderFrom;
    }

    /**
     * @param $id
     * @param $title
     * @param $description
     */
    public function updateItem($id, $title, $description){
        $updateData = ['name' => $title, 'description' => $description];
        return $this->where('id', $id)->update($updateData);
    }

    /**
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getById($id){
        return $this->find($id);
    }

    /**
     * @param $request
     * @param $columns
     * @return array
     */
    public function generateOrderFromTable($request, $columns){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('order_froms')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('users', 'order_froms.user_id', '=', 'users.id')
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('order_froms')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('users', 'order_froms.user_id', '=', 'users.id');

        if($where){
            $selectData->whereRaw($where);
            $recordsFiltered->whereRaw($where);
        }
//echo $selectData->toSql();die;
        /*
         * Output
         */
        return array(
            "draw"            => intval( $request['draw'] ),
            "recordsTotal"    => intval( $selectLength->count() ),
            "recordsFiltered" => intval( $recordsFiltered->count() ),
            "data"            => $selectData->get()
        );
    }
}

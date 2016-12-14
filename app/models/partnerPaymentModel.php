<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kacana\DataTables;

class partnerPaymentModel extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'partner_payments';
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partnerPaymentDetail()
    {
        return $this->hasMany('App\models\partnerPaymentDetailModel', 'payment_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\models\User', 'user_id');
    }

    public function generatePaymentHistoryTable($request, $columns, $userId){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        $arraySelect = $datatables::pluck($columns, 'db');
        array_push($arraySelect, DB::raw('COUNT(kacana_partner_payment_detail.payment_id) as count_item_order_detail'));

        // Main query to actually get the data
        $selectData = DB::table('partner_payments')
            ->select($arraySelect)
            ->leftJoin('partner_payment_detail', 'partner_payments.id', '=', 'partner_payment_detail.payment_id')
            ->where('partner_payments.user_id', $userId)
            ->orderBy($order['field'], $order['dir'])
            ->groupBy('partner_payment_detail.payment_id')
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength =  DB::table('partner_payments')
            ->select($datatables::pluck($columns, 'db'))
            ->where('partner_payments.user_id', $userId)
            ->leftJoin('partner_payment_detail', 'partner_payments.id', '=', 'partner_payment_detail.payment_id')
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
            "recordsTotal"    => intval( $selectLength->count() ),
            "recordsFiltered" => intval( $recordsFiltered->count() ),
            "data"            => $selectData->get()
        );
    }

    public function generatePartnerPaymentTable($request, $columns){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        $arraySelect = $datatables::pluck($columns, 'db');
        array_push($arraySelect, DB::raw('COUNT(kacana_partner_payment_detail.payment_id) as count_item_order_detail'));

        // Main query to actually get the data
        $selectData = DB::table('partner_payments')
            ->select($arraySelect)
            ->leftJoin('partner_payment_detail', 'partner_payments.id', '=', 'partner_payment_detail.payment_id')
            ->leftJoin('users', 'partner_payments.user_id', '=', 'users.id')
            ->orderBy($order['field'], $order['dir'])
            ->groupBy('partner_payment_detail.payment_id')
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength =  DB::table('partner_payments')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('partner_payment_detail', 'partner_payments.id', '=', 'partner_payment_detail.payment_id')
            ->leftJoin('users', 'partner_payments.user_id', '=', 'users.id')
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
            "recordsTotal"    => intval( $selectLength->count() ),
            "recordsFiltered" => intval( $recordsFiltered->count() ),
            "data"            => $selectData->get()
        );
    }

    public function createItem( $data){
        $object = new partnerPaymentModel();

        foreach($data as $k=>$v){
            $object->{$k} = $v;
        }

        $object->save();

        return $object;
    }

    public function updateItem($id, $item){
        $this->where('id', $id)->update($item);

        return $this->find($id);
    }

    public function getItem($id){
        return $this->find($id);
    }


}

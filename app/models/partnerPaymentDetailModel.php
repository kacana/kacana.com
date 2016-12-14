<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use Kacana\DataTables;

class partnerPaymentDetailModel extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'partner_payment_detail';
    public $timestamps = true;

    /**
     * Get the order detail associated with order
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partnerPayment()
    {
        return $this->belongsTo('App\models\partnerPaymentModel', 'payment_id');
    }

    public function orderDetail()
    {
        return $this->belongsTo('App\models\orderDetailModel', 'order_detail_id');
    }

    public function createItem( $data){
        $object = new partnerPaymentDetailModel();

        foreach($data as $k=>$v){
            $object->{$k} = $v;
        }

        $object->save();

        return $object;
    }
}

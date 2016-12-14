<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Carbon\Carbon;
use Image;
use DB;
use Kacana\DataTables;

/**
 * Class User
 * @package App\models
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

    /**
     * @var bool
     */
    public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'role'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    /**
     * Get the user type for user
     */
    public function userType()
    {
        return $this->belongsTo('App\models\UserType');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAddress()
    {
        return $this->hasMany('App\models\addressReceiveModel');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userSocial()
    {
        return $this->hasMany('App\models\userSocialModel', 'user_id', 'id');
    }

    /*
     * Get the order associated with user
     */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany('App\models\orderModel');
    }

    /**
     * Get the products associated with tags
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function productLike()
    {
        return $this->belongsToMany('App\models\productModel',  'user_product_like', 'user_id', 'product_id')->withPivot('created_at','product_url');
    }

    public function partnerPayment()
    {
        return $this->hasMany('App\models\partnerPaymentModel', 'user_id', 'id');
    }


    /**
     * @param $item
     * @return User
     */
    public function createItem($item)
    {
        $user = new User;
        if(isset($item['password']) && $item['password']!=''){
            $user->password = $item['password'];
        }
        $user->name = $item['name'];
        $user->email = $item['email'];
        $user->phone = $item['phone'];
        $user->role = $item['role'];
        $user->user_type = isset($item['user_type'])?$item['user_type']:'';
        $user->status = isset($item['status'])?$item['status']:KACANA_USER_STATUS_INACTIVE;
        $user->created = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');


        //update image after save product
        if (isset($item['image']) && ($item['image']!=='undefined')) {
            $user->image = $item['image'];
        }
        $user->save();

        return $user;
    }

    /**
     * @param $id
     * @param $item
     * @return mixed
     */
    function updateItem($id, $item)
    {
        $item['updated_at'] = date('Y-m-d H:i:s');
        $this->where('id', $id)->update($item);
        return $this->find($id);
    }

    /**
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email){
        return $this->where('email', $email)->first();
    }

    public function getUserById($id){
        return $this->find($id);
    }

    /**
     * @param $phone
     * @return mixed
     */
    public function getUserByPhone($phone){
        return $this->where('phone', $phone)->first();
    }

    /*
     * Get User By Order Id
     *
     * @param int $id
     * @return array
     */
    /**
     * @param $id
     */
    public function getUserByOrderId($id){

    }

    /**
     * @param $request
     * @param $columns
     * @return array
     */
    public function generateUserTable($request, $columns){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('users')
            ->select($datatables::pluck($columns, 'db'))
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('users')
            ->select($datatables::pluck($columns, 'db'));

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
    
    public function reportDetailTableUser($request, $columns){

        $datatables = new DataTables();
        $type = $request['type'];
        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );
        $dateSelected = $request['dateSelected'];

        if($type == 'day')
            $typeWhere = DB::raw('DATE_FORMAT(created, "%Y-%m-%d")');
        elseif($type == 'month') {
            $dateSelected = substr($dateSelected,0,7);
            $typeWhere =DB::raw('DATE_FORMAT(created, "%Y-%m")');
        }
        elseif($type == 'year') {
            $dateSelected = substr($dateSelected,0,4);
            $typeWhere = DB::raw('DATE_FORMAT(created, "%Y")');
        }
        // Main query to actually get the data
        $selectData = DB::table('users')
            ->select($datatables::pluck($columns, 'db'))
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit'])
            ->where($typeWhere,'=',$dateSelected);


        // Data set length
        $recordsFiltered = $selectLength = DB::table('users')
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
            "recordsTotal"    => intval( $selectLength->count() ),
            "recordsFiltered" => intval( $recordsFiltered->count() ),
            "data"            => $selectData->get()
        );
    }

    public function countUser($duration = false){
        $date = Carbon::now()->subDays($duration);
        if($duration === false)
            return $this->count();
        else
            return $this->where('created', '>=', $date)->count();
    }

    public function reportUser($startTime, $endTime, $type = 'date')
    {
        $userReport =  $this->where('created', '>=', $startTime)
                            ->where('created', '<=', $endTime);
        if($type == 'day')
            $userReport->select('*', DB::raw('DATE_FORMAT(created, "%Y-%m-%d") as date'), (DB::raw('count(id) as item')))
                ->groupBy('date');
        elseif($type == 'month')
            $userReport->select('*', DB::raw('DATE_FORMAT(created, "%Y-%m") as date'), (DB::raw('count(id) as item')))
                ->groupBy('date');
        elseif($type == 'year')
            $userReport->select('*',DB::raw('DATE_FORMAT(created, "%Y") as date'), (DB::raw('count(id) as item')))
                ->groupBy('date');
        return $userReport->get();
    }

    public function generateUserWaitingTransferTable($request, $columns){
        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        // Main query to actually get the data
        $selectData = DB::table('users')
            ->select($datatables::pluck($columns, 'db'))
            ->leftJoin('orders', 'orders.user_id', '=', 'users.id')
            ->leftJoin('order_detail', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->orderBy($order['field'], $order['dir'])
            ->where('shipping.status', KACANA_SHIP_STATUS_FINISH)
            ->whereNull('partner_payment_detail.payment_id')
            ->groupBy('users.id')
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('users')
            ->leftJoin('orders', 'orders.user_id', '=', 'users.id')
            ->leftJoin('order_detail', 'order_detail.order_id', '=', 'orders.id')
            ->leftJoin('shipping', 'shipping.id', '=', 'order_detail.shipping_service_code')
            ->leftJoin('partner_payment_detail', 'order_detail.id', '=', 'partner_payment_detail.order_detail_id')
            ->leftJoin('partner_payments', 'partner_payment_detail.payment_id', '=', 'partner_payments.id')
            ->where('shipping.status', KACANA_SHIP_STATUS_FINISH)
            ->whereNull('partner_payment_detail.payment_id')
            ->groupBy('users.id')
            ->select($datatables::pluck($columns, 'db'));

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

}

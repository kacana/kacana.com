<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Carbon\Carbon;
use Kacana\DataTables;

class facebookCommentModel extends Model  {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'facebook_comments';
    public $timestamps = true;

    /**
     * Create facebook Comment Model
     *
     * @param $data
     * @return facebookCommentModel
     */
    public function createItem($data)
    {
        $facebookComment = new facebookCommentModel();

        foreach($data as $key => $value){
            $facebookComment->{$key} = $value;
        }
        $facebookComment->save();

        return $facebookComment;
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
        $selectData = DB::table($this->table)
            ->select($datatables::pluck($columns, 'db'))
            ->orderBy($order['field'], $order['dir'])
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table($this->table)
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

<?php namespace App\models;

use App\services\chatService;
use Illuminate\Database\Eloquent\Model;
use Kacana\DataTables;
use DB;

class blogCommentModel extends Model {


    protected $table = 'blog_comments';

    public $timestamps = true;

    /**
     * Get the tags associated with product
     */
    public function user()
    {
        return $this->belongsTo('App\models\User', 'user_id');
    }

    public function createItem(){

    }

    public function generateCommentTable($request, $columns, $postId){

        $datatables = new DataTables();

        $limit = $datatables::limit( $request, $columns );
        $order = $datatables::order( $request, $columns );
        $where = $datatables::filter( $request, $columns );

        $arraySelect = $datatables::pluck($columns, 'db');

        // Main query to actually get the data
        $selectData = DB::table('blog_comments')
            ->select($arraySelect)
            ->leftJoin('users', 'blog_comments.user_id', '=', 'users.id')
            ->orderBy($order['field'], $order['dir'])
            ->where('blog_comments.post_id', $postId)
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('blog_comments')
            ->select($arraySelect)
            ->leftJoin('users', 'blog_comments.user_id', '=', 'users.id')
            ->orderBy($order['field'], $order['dir'])
            ->where('blog_comments.post_id', $postId);

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

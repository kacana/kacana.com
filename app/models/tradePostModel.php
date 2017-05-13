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


class tradePostModel extends Model
{
    protected $table = 'trade_post';

    public $timestamps = true;

    public function createItem($productId, $postBody, $dataPost, $userId){
        $tradePost = new tradePostModel();

        $tradePost->product_id = $productId;
        $tradePost->post_body = $postBody;
        $tradePost->data_post = \GuzzleHttp\json_encode($dataPost);
        $tradePost->user_id = $userId;
        $tradePost->save();

        return $tradePost;
    }
}
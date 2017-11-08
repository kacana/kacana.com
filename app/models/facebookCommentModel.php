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
}

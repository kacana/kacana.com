<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Carbon\Carbon;
use Kacana\DataTables;

class blogPostViewModel extends Model  {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blog_post_views';
    public $timestamps = true;

    public function createItem($data)
    {
        $blogPostView = new blogPostViewModel();

        foreach($data as $key => $value){
            $blogPostView->{$key} = $value;
        }
        $blogPostView->save();

        return $blogPostView;
    }
}

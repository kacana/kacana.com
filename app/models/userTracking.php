<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

class userTracking extends Model {

    protected $table = 'user_tracking';
    public $timestamps = true;

    public function createItem($data){
        $userTracking = new userTracking();

        foreach($data as $key => $value){
            $userTracking->{$key} = $value;
        }

        $userTracking->save();

        return $userTracking;
    }
}

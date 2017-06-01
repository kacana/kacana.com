<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

class userTrackingHistory extends Model {

    protected $table = 'user_tracking_history';
    public $timestamps = true;

    public function createItem($data){
        $userTrackingHistory = new userTrackingHistory();

        foreach($data as $key => $value){
            $userTrackingHistory->{$key} = $value;
        }
        $userTrackingHistory->save();
        return $userTrackingHistory;
    }

    public function getItem($idTracking){
        return $this->find($idTracking);
    }
}

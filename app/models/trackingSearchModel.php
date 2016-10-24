<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Carbon\Carbon;

class trackingSearchModel extends Model  {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tracking_search';
    public $timestamps = true;

    /**
     * Create product view by data array
     *
     * @param $data
     * @return tagModel
     */
    public function createItem($data)
    {
        $trackingSearch = new trackingSearchModel();

        foreach($data as $key => $value){
            $trackingSearch->{$key} = $value;
        }
        $trackingSearch->save();

        return $trackingSearch;
    }

    public function countTrackingSearch($duration = false){
        $date = Carbon::now()->subDays($duration);
        if($duration === false)
            return $this->count();
        else
            return $this->where('created_at', '>=', $date)->count();
    }

    public function reportTrackingSearch($startTime, $endTime, $type = 'date')
    {
        $trackingSearchReport =  $this->where('created_at', '>=', $startTime)
            ->where('created_at', '<=', $endTime);
        if($type == 'day')
            $trackingSearchReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        elseif($type == 'month')
            $trackingSearchReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        elseif($type == 'year')
            $trackingSearchReport->select('*',DB::raw('DATE_FORMAT(created_at, "%Y") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        return $trackingSearchReport->get();
    }

}

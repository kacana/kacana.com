<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Carbon\Carbon;

class productViewModel extends Model  {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_view';
    public $timestamps = true;

    /**
     * Get the tags associated with product
     */
    public function product()
    {
        return $this->belongsTo('App\models\Product');
    }

    /**
     * Create product view by data array
     *
     * @param $data
     * @return tagModel
     */
    public function createItem($data)
    {
        $productView = new productViewModel();

        foreach($data as $key => $value){
            $productView->{$key} = $value;
        }
        $productView->save();

        return $productView;
    }

    public function countProductView($duration = false){
        $date = Carbon::now()->subDays($duration);
        if($duration === false)
            return $this->count();
        else
            return $this->where('created_at', '>=', $date)->count();
    }

    public function reportProductView($startTime, $endTime, $type = 'date')
    {
        $productViewReport =  $this->where('created_at', '>=', $startTime)
            ->where('created_at', '<=', $endTime);
        if($type == 'day')
            $productViewReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        elseif($type == 'month')
            $productViewReport->select('*', DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        elseif($type == 'year')
            $productViewReport->select('*',DB::raw('DATE_FORMAT(created_at, "%Y") as date'), (DB::raw('count(*) as item')))
                ->groupBy('date');
        return $productViewReport->get();
    }

}

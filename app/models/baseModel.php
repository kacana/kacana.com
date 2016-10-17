<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class baseModel
 * @package App\models
 */
class baseModel extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param boolean $timestamps
     */
    public function setTimestamps($timestamps)
    {
        $this->timestamps = $timestamps;
    }

    /**
     * @return boolean
     */
    public function isTimestamps()
    {
        return $this->timestamps;
    }

    /**
     * @param $id
     * @param $status
     * @param $table
     * @return int
     */
    public function changefieldDropdown($id, $value, $field, $table)
    {

        $tagRelations = DB::table($table);

        return $tagRelations->where('id' , '=', $id)
            ->update([$field=>$value]);
    }

}
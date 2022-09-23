<?php

namespace App\Models;

use App\Base\BaseModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class MstFedLocalLevel extends BaseModel
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'mst_fed_local_level';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = ['id','code','district_id','level_type_id','name_en','name_lc','wards_count','gps_lat','gps_long','display_order','remarks','lmbiscode'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function districtEntity()
    {
        return $this->belongsTo(MstFedDistrict::class,'district_id','id');
    }
    public function localLevelTypeEntity()
    {
        return $this->belongsTo(MstFedLocalLevelType::class,'level_type_id','id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

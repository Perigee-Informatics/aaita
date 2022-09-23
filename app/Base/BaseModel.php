<?php
namespace App\Base;

use App\Models\Country;
use App\Models\AppClient;
use App\Models\MstFedDistrict;
use App\Models\MstFedProvince;
use App\Base\Traits\ComboField;
use App\Base\Traits\Conversion;
use App\Models\MstFedLocalLevel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class BaseModel extends  Model
{
    use CrudTrait;
    use ComboField;
    use Conversion;

    protected $primaryKey = 'id';
    
    public function setGuarded($guarded=["id","created_at","created_by"]){

        $this->guarded = $guarded;
    }
    

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $columns = Schema::getColumnListing($model->getTable()); 
            if(in_array('code', $columns)){
                $code = self::generateCode($model);
                $model->code = $code;   
            }

            if(in_array('created_by', $columns)){
                $model->created_by =  backpack_user()->id;
            }

            // if(in_array('client_id', $columns)){
            //     $model->client_id =  backpack_user()->client_id;
            // }
        });

        static::updating(function ($model){
            $columns = Schema::getColumnListing($model->getTable()); 
            if(in_array('updated_by', $columns)){
                $model->updated_by =  backpack_user()->id;
            }
        });
    }
    
    public static function generateCode($model)
    {
        $table = $model->getTable();
        $qu = DB::table($table)
                    ->selectRaw('COALESCE(max(code::NUMERIC),0)+1 as code')
                    ->whereRaw("(code ~ '^([0-9]+[.]?[0-9]*|[.][0-9]+)$') = true");
                    // ->where('deleted_uq_code',1);
                if(in_array('office_id',$model->getFillable())){
                    $qu->where('office_id', backpack_user()->office_id);
                }
                $rec = $qu->first();
                if(isset($rec)){
                    $code = $rec->code;
                }
                else{
                    $code = 1;
                }
                return $code;
    }

    // Relations
 
    public function countryEntity(){
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function provinceEntity(){
        return $this->belongsTo(MstFedProvince::class,'province_id','id');
    }

    public function districtEntity(){
        return $this->belongsTo(MstFedDistrict::class,'district_id','id');
    }

    public function localLevelEntity(){
        return $this->belongsTo(MstFedLocalLevel::class,'local_level_id','id');
    }
   


}

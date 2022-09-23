<?php
namespace App\Base\Traits;

use Illuminate\Support\Facades\DB;


/**
 * To get combo filed from model
 */
trait ComboField
{

    public function getComboFieldAttribute()
    {
        return $this->code. ' - '.$this->name_en;
    }
    
    public function getFilterComboOptions()
    {
        $a = self::selectRaw("code|| ' - ' || name_en as name_en , id");

        return $a->orderBy('id', 'ASC')
            ->get()
            ->keyBy('id')
            ->pluck('name_lc', 'id')
            ->toArray();
    }


    public function getCodeFilterOptions()
    {
        $a = self::selectRaw("code, id");

        return $a->get()
            ->keyBy('id')
            ->pluck('code', 'id')
            ->toArray();
    }

    public function getFieldComboOptions($query)
    {
        $query->selectRaw("code|| ' - ' || name_en as name_en, id");

        return $query->orderBy('id', 'ASC')
            ->get();
    }

    public function getClientFieldComboOptions($query)
    {
        $query->selectRaw("lmbiscode|| ' - ' || name_lc as name_lc, id")->where('is_tmpp_applicable', true);

        return $query->orderBy('id', 'ASC')
            ->get();
    }


    public function getProvinceFilterComboOptions()
    {
        $a = self::selectRaw("code|| ' - ' || name_en as name_en , id");
                   
        return $a->orderBy('id', 'ASC')
        ->get()
        ->keyBy('id')
        ->pluck('name_en', 'id')
        ->toArray();

    }

 

}

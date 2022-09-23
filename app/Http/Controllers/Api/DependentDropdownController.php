<?php

namespace App\Http\Controllers\Api;

use App\Models\MstUnit;
use App\Models\AppClient;
use App\Models\PtProject;
use App\Models\MstFedDistrict;
use App\Models\MstFedProvince;
use App\Models\MstNepaliMonth;
use App\Models\MstFedLocalLevel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\MstProjectSubCategory;
use Illuminate\Support\Facades\Validator;


class DependentDropdownController extends Controller
{

    public function getdistrict($id)
    {   
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            abort(404);
        }else {
            $district = MstFedDistrict::where('province_id', $id)->get();
            return response()->json($district);
        }
    }
    public function getlocal_level($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            abort(404);
        }else {
            $local_level = MstFedLocalLevel::where('district_id', $id)->get();
            return response()->json($local_level);
        }
       
    }
   
}

<?php

namespace App\Base;

use Illuminate\Http\Request;
use App\Base\BaseCrudController;
use Illuminate\Support\Facades\DB;

class BasePivotController extends BaseCrudController
{
    public function setUp()
    {
        $this->setStyles();
        $this->setScripts();
    }

    public function fromView($view){
        return view($view, $this->data);
    }

    private function setScripts()
    {
        $load_js = array();
        $load_js[] = asset('pivot/cdnjs/jquery-ui.min.js');
        $load_js[] = asset('pivot/cdnjs/d3.min.js');
        $load_js[] = asset('pivot/cdnjs/jquery.ui.touch-punch.min.js');
        $load_js[] = asset('pivot/cdnjs/papaparse.min.js');
        $load_js[] = asset('pivot/cdnjs/c3.min.js');
        $load_js[] = asset('pivot/pivot.js');
        $load_js[] = asset('pivot/d3_renderers.js');
        $load_js[] = asset('pivot/c3_renderers.js');
        $load_js[] = asset('pivot/export_renderers.js');
        $load_js[] = asset('pivot/pivottable_base.js');
        $load_js[] = asset('js/custom.js');
        $load_js[] = asset('js/jquery.print.js');
        $this->data['load_scripts'] = $load_js;
    }

    private function setStyles()
    {
        $load_css = array();
        $load_css[] = asset('pivot/cdnjs/c3.min.css');
        $load_css[] = asset('pivot/pivot.css');
        $load_css[] = asset('pivot/pivottable.custom1.css');
        $this->data['load_css'] = $load_css;
    }

    public function getMasterData()
    {

            $mst_fed_district = DB::table('mst_fed_district')->select('id', 'name_lc') ->get();
            $fed_district=array();
            foreach($mst_fed_district as $tran) { $fed_district[$tran->id]=$tran->name_lc; }

            $mst_fed_local_level = DB::table('mst_fed_local_level')->select('id', 'name_lc') ->get();
            $fed_local_level=array();
            foreach($mst_fed_local_level as $tran) { $fed_local_level[$tran->id]=$tran->name_lc; }

            $mst_project_category = DB::table('mst_project_category')->select('id', 'name_lc') ->get();
            $project_category=array();
            foreach($mst_project_category as $tran) { $project_category[$tran->id]=$tran->name_lc; }

            $mst_project_status = DB::table('mst_project_status')->select('id', 'name_lc') ->get();
            $project_status=array();
            foreach($mst_project_status as $tran) { $project_status[$tran->id]=$tran->name_lc; }

            $mst_fiscal_year = DB::table('mst_fiscal_year')->select('id', 'code as name_lc') ->get();
            $fiscal_year=array();
            foreach($mst_fiscal_year as $tran) { $fiscal_year[$tran->id]=$tran->name_lc; }

            $mst_executing_entity_type = DB::table('mst_executing_entity_type')->select('id', 'name_lc') ->get();
            $executing_entity_type=array();
            foreach($mst_executing_entity_type as $tran) { $executing_entity_type[$tran->id]=$tran->name_lc; }
      
        $arr['fed_district']=$fed_district;
        $arr['fed_local_level']=$fed_local_level;
        $arr['project_category']=$project_category;
        $arr['project_status']=$project_status;
        $arr['fiscal_year']=$fiscal_year;
        $arr['executing_entity_type']=$executing_entity_type;
        return $arr;

    }
  
}

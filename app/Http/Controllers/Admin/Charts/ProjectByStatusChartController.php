<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\PtProject;
use App\Models\MstProjectStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
// use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ConsoleTVs\Charts\Classes\Highcharts\Chart;
use Backpack\CRUD\app\Http\Controllers\ChartController;

/**
 * Class ProjectByStatusChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProjectByStatusChartController extends ChartController
{
    protected $ids;
    protected $fiscal_year_id;
    public function setup()
    {
        $this->chart = new Chart();
        // MANDATORY. Set the labels for the dataset points

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/project-by-status'));

        $this->chart->options([
            'plotOptions' => [
                'pie' => [
                    'allowPointSelect' => true,
                    'cursor' => 'pointer',
                    'showInLegend'=> true,
                    'dataLabels'=> [
                        'enabled' => false,
                    ],
                    
                ]
            ],
        ]);

          
        // OPTIONAL
        $this->chart->minimalist(false);
        $this->chart->displayLegend(true);
        $this->chart->height(250);
    }

    public function response()
    {
        // call the data() method, if present
        if (method_exists($this, 'data')) {
            $this->data();
        }

        if ($this->chart) {
            $response = $this->chart->api();
        } else {
            $response = $this->api();
        }
        $response = json_decode($response);
        $raw_data = $response[0]->data;

        foreach($raw_data as $key => $rd){
            if(array_key_exists($key, $this->ids)){
                $response[0]->data[$key]->id= $this->ids[$key];
            }
        }
        $response = json_encode($response);
        return response($response)->withHeaders([
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        $this->fiscal_year_id = Session::get('fiscal_year_id');
        $client_clause = "1=1";
        $fiscal_year_clause = "1=1";

        if(isset($this->fiscal_year_id)){
            $fiscal_year_clause = "pp.fiscal_year_id = ".$this->fiscal_year_id;
        }

        if(backpack_user()->isClientUser()){
            $client_id = backpack_user()->client_id;
            $client_clause = "pp.client_id = ".$client_id;
        }
        $pt_project_data = DB::table('pt_project as pp')
                    ->join('mst_project_status as mps','mps.id','pp.project_status_id')
                    ->select('mps.id as status_id','mps.name_lc as name',DB::raw('count(pp.project_status_id) as total'))
                    ->where('mps.is_active',true)
                    ->where('pp.project_status_id', 1)
                    ->whereRaw($fiscal_year_clause)
                    ->whereRaw($client_clause)
                    ->groupBy('mps.id');

        $pt_project_selected_data = DB::table('pt_selected_project as pp')
                        ->join('mst_project_status as mps','mps.id','pp.project_status_id')
                        ->select('mps.id as status_id','mps.name_lc as name',DB::raw('count(pp.project_status_id) as total'))
                        ->where('mps.is_active',true)
                        ->whereRaw($fiscal_year_clause)
                        ->whereRaw($client_clause)
                        ->groupBy('mps.id');

        $datas = $pt_project_data->union($pt_project_selected_data)->get();

        $ids = [];
        $labels =[];
        $values = [];
        foreach($datas as $row){
            $labels [] = $row->name;
            $ids [] = $row->status_id;
            $values [] = $row->total;
        }
        $this->ids =  $ids;
        $this->chart->labels($labels);
        $this->chart->dataset('Count', 'pie', $values)->color(['teal','cyan','green','brown']);

    }

}
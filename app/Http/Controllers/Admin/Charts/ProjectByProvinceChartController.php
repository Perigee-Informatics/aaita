<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\MstFiscalYear;
// use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Models\MstFedProvince;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use ConsoleTVs\Charts\Classes\Highcharts\Chart;
use Backpack\CRUD\app\Http\Controllers\ChartController;

/**
 * Class ProjectByProvinceChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProjectByProvinceChartController extends ChartController
{
    protected $new_datas;
    protected $fiscal_year_id;

    public function setup()
    {
        $this->chart = new Chart();

        // MANDATORY. Set the labels for the dataset points
        // $labels = MstFiscalYear::orderBy('id')->pluck('code')->toArray();
        $this->chart->labels(['States']);

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/project-by-province'));

        $this->chart->options([
            'yAxis' => [
                'title' => [
                    'text' => 'No of Projects',
                ],
            ],
            'plotOptions' => [
                'column' => [
                    'allowPointSelect' => true,
                    'cursor' => 'pointer'
                ]
            ],
        ]);

      


        // OPTIONAL
        $this->chart->minimalist(false);
        $this->chart->displayLegend(true);
        $this->chart->height(250);

    }

    public function getLibraryFilePath()
    {
        return NULL;
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */

     
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
        foreach($response as $key => $rd){
            // dd($response, $rd);
            $response[$key]->province_id= $this->new_datas[$key]['province_id'];
            $response[$key]->chart_name= 'project_by_province';
        }
        $response = json_encode($response);
        
        return response($response)->withHeaders([
            'Content-Type' => 'application/json',
        ]);
    }

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
        
        $province_projects = DB::table('pt_project as pp')->select('mfp.name_lc','mfp.id as province_id',DB::raw('count(mfp.id) as total'))
                            ->join('app_client as ac','ac.id','pp.client_id')
                            ->join('mst_fed_local_level as mfll','mfll.id','ac.fed_local_level_id')
                            ->join('mst_fed_district as mfd','mfd.id','mfll.district_id')
                            ->join('mst_fed_province as mfp','mfp.id','mfd.province_id')
                            ->join('mst_fiscal_year as mfy','mfy.id','pp.fiscal_year_id')
                            ->whereIn('pp.project_status_id',[2,3])
                            ->whereRaw($fiscal_year_clause)
                            ->whereRaw($client_clause)
                            ->groupBy('mfp.id')
                            ->orderBy('mfp.id','ASC')
                            ->get();

        foreach($province_projects as $row){
            $datas[$row->province_id][] = $row;
        }

        foreach($datas as $rows){
            foreach($rows as $row){
                $new_datas[$row->province_id]['name'] = $row->name_lc ;
                $new_datas[$row->province_id]['data'][] = $row->total ;
                $new_datas[$row->province_id]['province_id'] = $row->province_id ;
            }
        }
        $new_datas = array_values($new_datas);
        $this->new_datas = $new_datas;
        $label_color = [
            0 => 'brown',
            1 => 'green',
            2 => 'red',
            3 => 'orange',
            4 => 'purple',
            5 => 'blue',
            6 => 'skyblue',
            7 => 'lightgreen',
            ];



        foreach ($this->new_datas as $key => $row) {
            $this->chart->dataset($row['name'], 'column',$row['data'])
            ->color($label_color[$key]);
        }

    }
}
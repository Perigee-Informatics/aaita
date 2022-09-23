<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\MstFiscalYear;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use ConsoleTVs\Charts\Classes\Highcharts\Chart;
use Backpack\CRUD\app\Http\Controllers\ChartController;
// use ConsoleTVs\Charts\Classes\Chartjs\Chart;

/**
 * Class ProjectByCategoryChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProjectByCategoryChartController extends ChartController
{
    protected $new_datas;
    protected $fiscal_year_id;

    public function setup()
    {
        $this->chart = new Chart();

        // MANDATORY. Set the labels for the dataset points
        $this->chart->labels(['Category']);

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/project-by-category'));

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
            $response[$key]->category_id= $this->new_datas[$key]['category_id'];
            $response[$key]->chart_name= 'project_by_category';
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
        $category_projects = DB::table('pt_selected_project as pp')->select('mpc.name_lc','mpc.id as category_id',DB::raw('count(mpc.id) as total'))
                                ->join('mst_project_category as mpc','mpc.id','pp.category_id')
                                ->join('mst_fiscal_year as mfy','mfy.id','pp.fiscal_year_id')
                                ->whereIn('pp.project_status_id',[2,3])
                                ->whereRaw($fiscal_year_clause)
                                ->whereRaw($client_clause)
                                ->groupBy('mpc.id')
                                ->orderBy('mpc.id','ASC')
                                ->get();

        foreach($category_projects as $row){
            $datas[$row->category_id][] = $row;
        }

        foreach($datas as $rows){
            foreach($rows as $row){
                $new_datas[$row->category_id]['name'] = $row->name_lc ;
                $new_datas[$row->category_id]['data'][] = $row->total ;
                $new_datas[$row->category_id]['category_id'] = $row->category_id ;
            }
        }
        $new_datas = array_values($new_datas);
        $this->new_datas = $new_datas;

        $label_color = [
            0 => 'red',
            1 => 'blue',
            2 => 'green',
            3 => 'orange',
            4 => 'purple',
            5 => 'brown',
            6 => 'teal',
            7 => 'lightgreen',
            8 => 'skyblue',
            ];

        foreach ($this->new_datas as $key => $row) {
            $this->chart->dataset($row['name'], 'column', $row['data'])
            ->color($label_color[$key]);
        }
    }
}
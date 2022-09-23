<?php

namespace App\Base;


use App\Models\AppClient;
use App\Models\AppSetting;
use App\Models\MstFiscalYear;
use App\Models\MstFedDistrict;
use App\Models\MstFedProvince;
use App\Base\Traits\ParentData;
use App\Models\MstFedLocalLevel;
use Illuminate\Support\Facades\DB;
use App\Base\Traits\CheckPermission;
use Illuminate\Support\Facades\Route;
use App\Base\Operations\ListOperation;
use App\Base\Operations\ShowOperation;
use App\Base\Operations\CreateOperation;
use App\Base\Operations\DeleteOperation;
use App\Base\Operations\UpdateOperation;
use Backpack\CRUD\app\Http\Controllers\CrudController;


class BaseCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;
    use ParentData;
    use CheckPermission;


    public function __construct()
    {

        if ($this->crud) {
            return;
        }

        $this->middleware(function ($request, $next) {
            $this->crud = app()->make('crud');
            // ensure crud has the latest request
            $this->crud->setRequest($request);
            $this->request = $request;
            $this->setupDefaults();
            $this->setup();
            $this->crud->denyAccess('show');
            $this->setupConfigurationForCurrentOperation();
            return $next($request);
        });
        // parent::__construct();
    }

    protected function addCodeField()
    {
        return [
            'name' => 'code',
            'label' => trans('common.code'),
            'type' => 'text',
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ];
    }

    protected function addReadOnlyCodeField()
    {
        return [
            'name' => 'code',
            'label' => trans('common.code'),
            'type' => 'text',
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
            'attributes' => [
                'id'=> 'code',
                'readonly' => true,
            ],
        ];
    }

    protected function addPlainHtml()
    {
        return   [
            'type' => 'custom_html',
            'name'=>'plain_html_1',
            'value' => '<br>',
        ];
    }

    protected function addNameEnField()
    {
        return [
            'name' => 'name_en',
            'label' => trans('common.name_en'),
            'type' => 'text',
            'attributes'=>[
                'id' => 'name-en',
                'required' => 'required',
                'max-lenght'=>200,
            ],
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ];
    }

    protected function addNameLcField()
    {
        return [
            'name' => 'name_lc',
            'label' => trans('common.name_lc'),
            'type' => 'text',
            'attributes'=>[
                'id' => 'name-lc',
                'required' => 'required',
                'max-lenght'=>200,
            ],
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ];
    }

    protected function addFiscalYearField()
    {
        return[
            'name' => 'fiscal_year_id',
            'type' => 'select2',
            'entity'=>'fiscalyearEntity',
            'attribute' => 'code',
            'model'=>MstFiscalYear::class,
            'label' => trans('common.fiscal_year'),
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
            'attributes'=>[
                'required' => 'Required',
            ],
        ];
    }

    protected function addProvinceField()
    {
        return [
            'name' => 'province_id',
            'type' => 'select2',
            'entity'=>'provinceEntity',
            'attribute' => 'name_en',
            'model'=>MstFedProvince::class,
            'label' => trans('common.fed_province'),
            'options'   => (function ($query) {
                return (new MstFedProvince())->getFieldComboOptions($query);
                    }),
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
            'attributes'=>[
                'required' => 'required',
             ],
        ];
    }
    protected function addDistrictField()
    {
        return  [
            'name' => 'district_id',
            'type' => 'select2',
            'entity'=>'districtEntity',
            'attribute' => 'name_en',
            'model'=>MstFedDistrict::class,
            'label' => trans('common.fed_district'),
            'options'   => (function ($query) {
                return (new MstFedDistrict())->getFieldComboOptions($query);
                    }),
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ];
    }

    protected function addLocalLevelField()
    {
        return [
            'name' => 'local_level_id',
            'type' => 'select2',
            'entity'=>'localLevelEntity',
            'attribute' => 'name_en',
            'model'=>MstFedLocalLevel::class,
            'label' => trans('common.fed_local_level'),
            'options'   => (function ($query) {
                return (new MstFedLocalLevel())->getFieldComboOptions($query);
                    }),
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ];
    }

    protected function addDateBsField()
    {
        return  [
            'name' => 'date_bs',
            'type' => 'nepali_date',
            'label' => trans('common.date_bs'),
            'attributes'=>[
                'id'=>'date_bs',
                'relatedId'=>'date_ad',
                'maxlength' =>'10',
            ],
             'wrapper' => [
                 'class' => 'form-group col-md-4',
            ],
        ];
    
    }
    protected function addDateAdField()
    {
        return [
            'name' => 'date_ad',
            'type' => 'date',
            'label' => trans('common.date_ad'),
            'attributes'=>[
                'id'=>'date_ad',
            ],
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ];
    }

    protected function addRemarksField()
    {
        return [
            'name' => 'remarks',
            'label' => trans('common.remarks'),
            'type' => 'textarea',
            'wrapper' => [
                'class' => 'form-group col-md-12',
            ],
        ];
    }

    
    public function addIsActiveField(){
        return [
            'name'=>'is_active',
            'label'=>trans('common.is_active'),
            'type'=>'radio',
            'default'=>1,
            'inline' => true,
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
            'options'=>
            [
                1=>'Yes',
                0=>'No',
            ],
        ];
    }

    public function addDisplayOrderField(){
        return [
            'name'=>'display_order',
            'type'=>'number',
            'label'=>trans('common.display_order'),
            'default'=> 0,
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ];
    }





    // common columns

    protected function addRowNumberColumn()
    {
        return [
            'name' => 'row_number',
            'type' => 'row_number',
            'label' => trans('common.row_number'),
        ];
    }

    protected function addCodeColumn()
    {
        return [
            'name' => 'code',
            'label' => trans('common.code'),
            'type' => 'text',
        ];
    }


    protected function addNameEnColumn()
    {
        return [
            'name' => 'name_en',
            'label' => trans('common.name_en'),
            'type' => 'text',
        ];
    }

    protected function addNameLcColumn()
    {
        return [
            'name' => 'name_lc',
            'label' => trans('common.name_lc'),
            'type' => 'text',
        ];
    }

    protected function addFiscalYearColumn()
    {
        return[
            'name' => 'fiscal_year_id',
            'type' => 'select',
            'entity'=>'fiscalyearEntity',
            'attribute' => 'code',
            'model'=>MstFiscalYear::class,
            'label' => trans('common.fiscal_year'),
        ];
    }

    protected function addProvinceColumn()
    {
        return [
            'name' => 'province_id',
            'type' => 'select',
            'entity'=>'provinceEntity',
            'attribute' => 'name_en',
            'model'=>MstFedProvince::class,
            'label' => trans('common.fed_province'),
        ];
    }
    protected function addDistrictColumn()
    {
        return  [
            'name' => 'district_id',
            'type' => 'select',
            'entity'=>'districtEntity',
            'attribute' => 'name_en',
            'model'=>MstFedDistrict::class,
            'label' => trans('common.fed_district'),
        ];
    }

    protected function addLocalLevelColumn()
    {
        return [
            'name' => 'local_level_id',
            'type' => 'select',
            'entity'=>'localLevelEntity',
            'attribute' => 'name_en',
            'model'=>MstFedLocalLevel::class,
            'label' => trans('common.fed_local_level'),
        ];
    }

    protected function addDateBsColumn()
    {
        return  [
            'name' => 'date_bs',
            'type' => 'nepali_date',
            'label' => trans('common.date_bs'),
        ];
    
    }
    protected function addDateAdColumn()
    {
        return [
            'name' => 'date_ad',
            'type' => 'date',
            'label' => trans('common.date_ad'),
        ];
    }

    
    public function addIsActiveColumn(){
        return [
            'name'=>'is_active',
            'label'=>trans('common.is_active'),
            'type'=>'radio',
            'options'=>
            [
                1=>'Yes',
                0=>'No',
            ],
        ];
    }

    public function addDisplayOrderColumn(){
        return [
            'name'=>'display_order',
            'type'=>'number',
            'label'=>trans('common.display_order'),
        ];
    }  



    //common filters

    public function addNameEnFilter(){
        return $this->crud->addFilter(
                [ 
                    'label' => trans('common.name_en'),
                    'type' => 'text',
                    'name' => 'name_en', 
                ],
                false,
                function ($value) { // if the filter is active
                    $this->crud->addClause('where', 'name_en', 'iLIKE', '%'.$value.'%');
                }
            );
    }

    public function addNameLcFilter(){
        return $this->crud->addFilter(
                [ 
                    'label' => trans('common.name_lc'),
                    'type' => 'text',
                    'name' => 'name_lc', 
                ],
                false,
                function ($value) { // if the filter is active
                    $this->crud->addClause('where', 'name_lc', 'iLIKE', '%'.$value.'%');
                }
            );
    }


    public function addProvinceIdFilter()
    {
 
        return $this->crud->addFilter(
            [ 
                'label' => 'Province',
                'type' => 'select2',
                'name' => 'province_id', // the db column for the foreign key
                'placeholder' => '--select province--',
                'attributes' => [
                    'onChange'=>'NAST.getDistrict(this)',
                ]
            ],
            function () {
                return (new MstFedProvince())->getProvinceFilterComboOptions();
            },
            function ($value) { // if the filter is active
                    $this->crud->query->whereProvinceId($value);
                // $data = $this->customFilterQuery();
                // $datas = collect(DB::select($data));
                // $client_ids = $datas->pluck('province')->toArray();
                // $this->crud->query->whereIn('client_id', $client_ids);
            }
        );
    }

    public function addDistrictIdFilter()
    {
        return $this->crud->addFilter(
            [ 
                'name'        => 'district_id',
                'type'        => 'select2',
                'label'       => 'Distrit',
                'placeholder' => '--select province first--',
                'attributes' => [
                    'onChange'=>'NAST.getFedLocalLevel(this)',
                ]
            ],
            function () {
            },
            function ($value) { // if the filter is active
                $this->crud->query->whereDistrictId($value);
                // $data = $this->customFilterQuery();
                // $datas = collect(DB::select($data));
                // $client_ids = $datas->pluck('client_id')->toArray();
                // $this->crud->query->whereIn('client_id', $client_ids);
            }
        );
    }

    public function customFilterQuery()
    {
        $province_id = request()->province_id;
        $district_id = request()->district_id;
        $table_name = $this->crud->model->getTable();
        $sql = "SELECT * from $table_name t
                -- inner join mst_fed_local_level mfll on mfll.id = ap.fed_local_level_id
                inner join mst_fed_district mfd on mfd.id = t.district_id
                inner join mst_fed_province mp on mp.id = t.province_id
                where 1 = 1";

        $whereas = [];
        if($province_id)
        {
            $whereas[] = ' and mp.id =' . $province_id;
        }
        if($district_id){
            $whereas[] = 'and mfd.id =' . $district_id;
        }
        $where_clause = implode(" " ,$whereas);
        $sql .= $where_clause;
        return $sql;
    }


}
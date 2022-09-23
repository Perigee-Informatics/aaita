<?php

namespace App\Http\Controllers\Admin;

use App\Models\MstFedDistrict;
use App\Base\BaseCrudController;
use App\Http\Requests\MstFedDistrictRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstFedDistrictCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstFedDistrictCrudController extends BaseCrudController
{

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(MstFedDistrict::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mstfeddistrict');
        CRUD::setEntityNameStrings(trans('menu.feddistrict'), trans('menu.feddistrict'));
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $col = [
            $this->addRowNumberColumn(),
            $this->addCodeColumn(),
            $this->addProvinceColumn(),
            $this->addNameEnColumn(),
            $this->addNameLcColumn(),
            [
                'label' => trans('GPS Lat'),
                'type' => 'text',
                'name' => 'gps_lat',
            ],
            [
                'label' => trans('GPS Long'),
                'type' => 'text',
                'name' => 'gps_long',
            ],
            $this->addDisplayOrderColumn(),
         
        ];
            $this->crud->addColumns($col);
            $this->crud->orderBy('display_order'); 
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(MstFedDistrictRequest::class);

        $arr = [
            $this->addReadOnlyCodeField(),
            $this->addPlainHtml(),
            $this->addProvinceField(),
            $this->addNameEnField(),
            $this->addNameLcField(),
            [
                'label' => trans('fedLocalLevel.gps_lat'),
                'type' => 'text',
                'name' => 'gps_lat',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'label' => trans('fedLocalLevel.gps_long'),
                'type' => 'text',
                'name' => 'gps_long',
                'wrapper' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            $this->addDisplayOrderField(),
        ];
        $arr = array_filter($arr);
        $this->crud->addFields($arr);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

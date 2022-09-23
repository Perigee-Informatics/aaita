<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Models\MstFedLocalLevel;
use App\Models\MstFedLocalLevelType;
use App\Http\Requests\MstFedLocalLevelRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstFedLocalLevelCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstFedLocalLevelCrudController extends BaseCrudController
{

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(MstFedLocalLevel::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mstfedlocallevel');
        CRUD::setEntityNameStrings(trans('menu.fedlocallevel'), trans('menu.fedlocallevel'));
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
            $this->addDistrictColumn(),
            $this->addNameEnColumn(),
            $this->addNameLcColumn(),
            [
                'label' => trans('Wards'),
                'type' => 'text',
                'name' => 'wards_count',
            ],
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
        CRUD::setValidation(MstFedLocalLevelRequest::class);

        $arr = [
            $this->addReadOnlyCodeField(),
            $this->addPlainHtml(),
            $this->addDistrictField(),
            [  // Select
                'label' => trans('fedLocalLevel.level_type_id'),
                'type' => 'select2',
                'name' => 'level_type_id', // the db column for the foreign key
                'entity' => 'localLevelTypeEntity', // the method that defines the relationship in your Model
                'attribute' => 'name_en', // foreign key attribute that is shown to user
                'model' => MstFedLocalLevelType::class,
                'wrapper' => [
                    'class' => 'form-group col-md-4'
                ],
                // optional
                'options'   => (function ($query) {
                    return (new MstFedLocalLevelType())->getFieldComboOptions($query);
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ],
            [
                'name' => 'lmbiscode',
                'label' => trans('LMBIS Code'),
                'type' => 'number',
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'attributes' => [
                    'id'=>'lmbis-code',
                ],
            ],
            $this->addNameEnField(),
            $this->addNameLcField(),
            [
                'label' => trans('fedLocalLevel.wards_count'),
                'type' => 'text',
                'name' => 'wards_count',
                'wrapper' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
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
            $this->addRemarksField(),
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

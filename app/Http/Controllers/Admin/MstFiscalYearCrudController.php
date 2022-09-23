<?php

namespace App\Http\Controllers\Admin;

use App\Models\MstFiscalYear;
use App\Base\BaseCrudController;
use App\Http\Requests\MstFiscalYearRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstFiscalYearCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstFiscalYearCrudController extends BaseCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(MstFiscalYear::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mstfiscalyear');
        CRUD::setEntityNameStrings(trans('menu.fiscalyear'), trans('menu.fiscalyear'));
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
            [
                'name'=>'from_date_bs',
                'label'=> trans('fiscalYear.from_date_bs'),
            ],

            [
                'name'=>'to_date_bs',
                'label'=> trans('fiscalYear.to_date_bs'),
            ],
            [
                'name'=>'is_current',
                'label'=>trans('Is Current'),
                'type'=>'radio',
                'default'=>0,
                'options'=>
                [
                    1=>'True',
                    0=>'False',
                ],
            ],


        ];
            $this->crud->addColumns($col);
      
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(MstFiscalYearRequest::class);

        $arr = [
            $this->addCodeField(),
            $this->addPlainHtml(),
            
            [
                'name' => 'from_date_bs',
                'type' => 'nepali_date',
                'label' => trans('fiscalYear.from_date_bs'),
                 'attributes'=>
                  [
                    'id'=>'from_date_bs',
                    'relatedId'=>'from_date_ad',
                    'maxlength' =>'10',
                 ],
                 'wrapper' => [
                     'class' => 'form-group col-md-3',
                 ],
            ],

            [
                'name' => 'from_date_ad',
                'type' => 'date',
                'label' => trans('fiscalYear.from_date_ad'),
                'attributes'=>
                [
                'id'=>'from_date_ad',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name' => 'to_date_bs',
                'type' => 'nepali_date',
                'label' => trans('fiscalYear.to_date_bs'),
                'attributes'=>
                [
                    'id'=>'to_date_bs',
                    'relatedId'=>'to_date_ad',
                    'maxlength' =>'10',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name' => 'to_date_ad',
                'type' => 'date',
                'label' => trans('fiscalYear.to_date_ad'),
                'attributes'=>[
                    'id'=>'to_date_ad'
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name'=>'is_current',
                'label'=>trans('Is Current'),
                'type'=>'radio',
                'default'=>0,
                'inline' => true,
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'options'=>
                [
                    1=>'True',
                    0=>'False',
                ],
            ],

                $this->addRemarksField(),
        ];

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

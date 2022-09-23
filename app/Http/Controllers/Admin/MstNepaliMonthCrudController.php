<?php

namespace App\Http\Controllers\Admin;

use App\Models\MstNepaliMonth;
use App\Base\BaseCrudController;
use App\Http\Requests\MstNepaliMonthRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstNepalMonthCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstNepaliMonthCrudController extends BaseCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(MstNepaliMonth::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mstnepalimonth');
        CRUD::setEntityNameStrings(trans('menu.nepalimonth'), trans('menu.nepalimonth'));
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $col=[
            $this->addRowNumberColumn(),
            $this->addCodeColumn(),
            $this->addNameEnColumn(),
            $this->addNameLcColumn(),
            $this->addDisplayOrderColumn(),

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
        CRUD::setValidation(MstNepaliMonthRequest::class);

        $arr = [
            $this->addReadOnlyCodeField(),
            $this->addPlainHtml(),
            $this->addNameEnField(),
            $this->addNameLcField(),
            [
                'name'=>'is_quarterly',
                'label'=>trans('Is Quaterly ?'),
                'type'=>'radio',
                'default'=>0,
                'inline' => true,
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'options'=>
                [
                    1=>'Yes',
                    0=>'No',
                ],
            ],
            [
                'name'=>'is_halfyearly',
                'label'=>trans('Is Half Yearly ? '),
                'type'=>'radio',
                'default'=>0,
                'inline' => true,
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'options'=>
                [
                    1=>'Yes',
                    0=>'No',
                ],
            ],
            [
                'name'=>'is_yearly',
                'label'=>trans('Is Yearly ?'),
                'type'=>'radio',
                'default'=>0,
                'inline' => true,
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'options'=>
                [
                    1=>'Yes',
                    0=>'No',
                ],
            ],
            $this->addDisplayOrderField(),
            $this->addRemarksField(),


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

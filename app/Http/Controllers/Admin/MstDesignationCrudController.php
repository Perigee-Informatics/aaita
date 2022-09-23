<?php

namespace App\Http\Controllers\Admin;

use App\Models\MstDesignation;
use App\Base\BaseCrudController;
use App\Http\Requests\MstDesignationRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstDesignationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstDesignationCrudController extends BaseCrudController
{
    public function setup()
    {
        CRUD::setModel(MstDesignation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mstdesignation');
        CRUD::setEntityNameStrings(trans('menu.designation'), trans('menu.designation'));
    }

    protected function setupListOperation()
    {
        $cols = [
            $this->addCodeColumn(),
            $this->addNameEnColumn(),
            $this->addNameLcColumn(),
            $this->addDisplayOrderColumn(),

        ];
        $this->crud->addColumns($cols);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(MstDesignationRequest::class);

        $arr = [
            $this->addReadOnlyCodeField(),
            $this->addPlainHtml(),
            $this->addNameEnField(),
            $this->addNameLcField(),
            $this->addDisplayOrderField(),
            $this->addRemarksField(),

        ];
    
        $arr = array_filter($arr);
        $this->crud->addFields($arr);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\CountryRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
/**
 * Class CountryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CountryCrudController extends BaseCrudController
{
  
    public function setup()
    {
        $this->crud->setModel('App\Models\Country');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/country');
        $this->crud->setEntityNameStrings('country', 'देश');


        $this->crud->addFilter(
            [
                'type' => 'text',
                'name' => 'name_en',
                'label' => 'Name'
            ],
            false,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'name_en', 'ILIKE', "%$value%");
            }
        );
        $this->crud->addFilter(
            [
                'type' => 'text',
                'name' => 'name_lc',
                'label' => 'नाम'
            ],
            false,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'name_lc', 'ILIKE', "%$value%");
            }
        );
    }

    protected function setupListOperation()
    {
        $col = [
            $this->addRowNumberColumn(),
            [
                'name' => 'country_code',
                'label' => trans('Country Code'),
                'type' => 'text',
            ],
            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('नाम'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('Name'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
         
    
            ];
        $this->crud->addColumns($col);
    }


    protected function setupCreateOperation()
    {
        $this->crud->setValidation(CountryRequest::class);

        $arr=[
         
            [
                'name' => 'country_code',
                'label' => trans('Country Code'),
                'type' => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],            
            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('Name'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('नाम'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            $this->addRemarksField(),
        ];
        $this->crud->addFields($arr);
    }



    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Notification;
use App\Base\BaseCrudController;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\NotificationRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NotificationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NotificationCrudController extends BaseCrudController
{

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Notification::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/notification');
        CRUD::setEntityNameStrings('Notification', 'Notification');
        $this->crud->denyAccess('create');
        $this->setFilters();
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */

    public function setFilters()
    {
       $this->crud->addFilter(
            [ 
                'label' => 'Status',
                'type' => 'select2',
                'name' => 'project_status', // the db column for the foreign key
            ],
            function () {
                return [
                    1  => 'New Project Demand Added',
                    2 =>  'New Project Progress Added',
                ];              
            },
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'project_status', $value);
            }
        );
    }

    protected function setupListOperation()
    {
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');
        $read_at_update = DB::table('notifications')->whereNull('read_at')->update(['read_at'=>Carbon::now()->todatetimestring()]);
        $col = [
            $this->addRowNumberColumn(),
            [
                'name'=>'content',
                'type'=>'model_function',
                'label' => 'Client Name',
                'function_name' => 'getContent'
            ],
            [
                'name'=>'is_read',
                'type'=>'model_function',
                'label' => 'Is Read',
                'function_name' => 'getRead'
            ],
            [
                'name'=>'project_status',
                'type'=>'model_function',
                'label' => 'Status',
                'function_name' => 'getStatus'
            ],
         
        ];
            $this->crud->addColumns($col);
            $this->crud->orderBy('created_at', 'ASC');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(NotificationRequest::class);

        // CRUD::setFromDb(); // fields

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
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

    public function getNewAddedData($notification_id,$project_id)
    {
        $project_status = Notification::findOrFail($notification_id)->project_status;
        $read_at_update = DB::table('notifications')->where('id', $notification_id)->update(['read_at'=>Carbon::now()->todatetimestring()]);
        if($project_status === 1){
            return redirect(backpack_url('newproject/'.$project_id.'/edit'));
        }else{
            return redirect(backpack_url('projectprogress/'.$project_id.'/edit'));
        }
    }
}

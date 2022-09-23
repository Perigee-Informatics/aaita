<?php
namespace  App\Base\Traits;

use App\Base\DataAccessPermission;


/**
 *  CheckPermission
 */
trait CheckPermission
{
    private $dataPermission;
    private $user;
    private $hasClientId;

    protected $permissions = ['list', 'create', 'update', 'delete', 'export', 'print'];
    protected $overRide = [];

    public function checkPermission($overRide =  [])
    {
        $this->overRide = $overRide;
        $this->dataPermission =  property_exists($this->crud->model, 'dataAccessPermission') ? $this->crud->model->dataAccessPermission : DataAccessPermission::SystemOnly;

        $this->user = backpack_user();

        $this->hasClientId = property_exists($this->crud->model, 'client_id');
        $this->hasClientId = in_array('client_id', $this->crud->model->getFillable());

        if($this->hasClientId) {

            $this->accessRoleWiseData();
        
        }
        $this->crud->denyAccess(['list', 'create', 'update', 'delete', 'export', 'print']);
        $this->filterPermission();
    }

    public function accessRoleWiseData()
    {
        $roles = $this->user->getRoleNames();
        foreach($roles as $role){

            switch($role) {
                case 'locallevel_admin':
                case 'locallevel_operator':
                    $this->crud->addClause('where','client_id',$this->user->client_id);
                break;

                default:
                    // code block
            }
    }

    }


 


    public function filterPermission()
    {
        $data = [];
        switch($this->dataPermission) {
            case DataAccessPermission::SystemOnly:
                $data = $this->systemOnly();
            break;
            case DataAccessPermission::DeveloperOnly:
                $data = $this->developerOnly();
            break;
            case DataAccessPermission::SystemDataShareWithClient:
                $data = $this->systemDataSharedWithClient();
            break;
            case DataAccessPermission::ShowClientWiseDataOnly:
                $data = $this->showClientWiseDataOnly();
            break;
        }
        $access = [];

        if (!empty($this->overRide)) {
            foreach ($this->overRide as $key => $value) {
                $data[$key] = $value;
            }
        }
        foreach (backpack_user()->getRoleNames() as $role) {
            $access = array_unique(array_merge($access, $data[$role])); 
        }

        $this->crud->allowAccess($access);

    }

    
    public function systemOnly()
    {
        return [
            'super_admin' => ['list', 'create', 'update', 'delete', 'export', 'print'],
            'central_admin' => ['list','create', 'update', 'export', 'print'],
            'central_operator' => ['list', 'update', 'export', 'print'],
            'central_viewer' => ['list', 'update', 'export', 'print'],
            'locallevel_admin' => ['list', 'update', 'export', 'print'],
            'locallevel_operator' => ['list', 'create'],
        ];
    }

    public function developerOnly()
    {
        return [
            'super_admin' => ['list', 'create', 'update', 'delete', 'export', 'print'],
            'central_admin' => ['list', 'update', 'export', 'print'],
            'central_operator' => ['list', 'update', 'export', 'print'],
            'central_viewer' => ['list', 'update', 'export', 'print'],
            'locallevel_admin' => ['list', 'update', 'export', 'print'],
            'locallevel_operator' => ['list', 'create'],
        ];
    }



    public function showClientWiseDataOnly()
    {
        return [
            'super_admin' => ['list', 'create', 'update', 'delete', 'export', 'print'],
            'central_admin' => ['list','create','update','export', 'print'],
            'central_operator' => ['list', 'update', 'export', 'print'],
            'central_viewer' => ['list', 'update', 'export', 'print'],
            'locallevel_admin' => ['list','create','update','delete','export', 'print'],
            'locallevel_operator' => ['list', 'create'], 
        ];
    }    
    public function systemDataSharedWithClient()
    {
        return [
            'super_admin' => ['list', 'create', 'update', 'delete', 'export', 'print'],
            'central_admin' => ['list', 'update', 'export', 'print'],
            'central_operator' => ['list', 'update', 'export', 'print'],
            'central_viewer' => ['list', 'update', 'export', 'print'],
            'locallevel_admin' => ['list', 'update', 'export', 'print'],
            'locallevel_operator' => ['list', 'create'],
        ];
    }    
}

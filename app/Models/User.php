<?php

namespace App\Models;

use App\Models\AppClient;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable,CrudTrait, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'users';
    protected $gaurded = ['id'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_no',
        'is_active',
        'client_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function assignRoleCustom($role_name, $model_id){
        $roleModel = Role::where('name', $role_name)
        ->take(1)
        ->get();
        
        if(count($roleModel) == 0){
            return "role doesnot exists";
        }
        DB::table('model_has_roles')->insert([
            'role_id' => $roleModel[0]->id,
            'model_type' => 'App\Models\BackpackUser',
            'model_id' => $model_id,
        ]);
    }
    

    public function clientEntity(){
        return $this->belongsTo(AppClient::class, 'client_id', 'id');
    }

    public function clientName()
    {
        $name = $this->clientEntity->name_lc;
        if($this->clientEntity->lmbiscode){
            $name .= '<br><span style="color:red; font-size:10px;">('.$this->clientEntity->lmbiscode.')</span>';
        }

       return $name;
    }

    public function isClientUser(){
        if($this->client_id  != 1000){
            return true;
        }
        else {
            return false;
        }
    }
}

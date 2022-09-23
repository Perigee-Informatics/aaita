<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin_role = Role::create(['name' => 'superadmin','field_name'=>'Super Admin']);
        $admin_role = Role::create(['name' => 'admin','field_name'=>'Admin']);
    
        

        // DB::table("")
        DB::table('users')->insert([
            'name' => 'superadmin',
            'email' => 'super@aitaa.org',
            'password' => bcrypt('Super@1234'),
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@aitaa.org',
            'password' => bcrypt('Admin@1234'),

        ]);

        $superadmin = User::where('email','super@aitaa.org')->first();
        $superadmin->assignRoleCustom("superadmin",$superadmin->id);

        $admin = User::where('email','admin@aitaa.org')->first();
        $admin->assignRoleCustom("admin",$admin->id);

    }
}

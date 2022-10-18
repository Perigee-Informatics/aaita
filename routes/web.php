<?php

// use App\Base\BasePivotController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\MemberCrudController;
use App\Http\Controllers\Admin\DashboardCrudController;
use App\Http\Controllers\Api\ProvinceDistrictController;
use App\Http\Controllers\Api\DependentDropdownController;
use App\Http\Controllers\Api\DistrictLocalLevelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return redirect(url('public/apply-for-membership/create'));
});
// Route::get('/admin', function(){
//     return view('errors.503');
// });
// Route::get('/admin/login', function(){
//     return view('errors.503');
// });
// Route::get('/', [DashboardController::class,'index']);
Route::get('/home', function(){
    return redirect(backpack_url('dashboard'));
});
Route::get('/update-province-id', [DashboardController::class,'updateProvinceId']);
Route::get('/home/get-page-content', [DashboardController::class,'getPageContent']);
Route::get('/admin', [AdminController::class,'redirect']);


Route::post('api/district/{province_id}', [ProvinceDistrictController::class,'index']);
Route::post('api/locallevel/{district_id}', [DistrictLocalLevelController::class,'index']);

Route::get('/district/{id}', [DependentDropdownController::class, 'getdistrict']);
Route::get('/local_level/{id}', [DependentDropdownController::class,'getlocal_level']);

Route::get('get-nepal-map-data', [DashboardCrudController::class,'getNepalMapdata']);
Route::get('get-province-data', [DashboardCrudController::class,'getProvinceData']);
Route::get('get-district-data', [DashboardCrudController::class,'getDistrictData']);
Route::get('get-all-members', [DashboardCrudController::class,'getMembersData']);
Route::get('get-geodata', [DashboardCrudController::class,'getGeoData']);

// Route::get('member/{member_id}/print-profile', [MemberCrudController::class,'printProfile']);

// Route::get('admin/report/masterdata', [BasePivotController::class,'getMasterData']);






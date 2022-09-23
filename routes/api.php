<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware'=>'api',
            'namespace' => 'App\Http\Controllers\Api'] 
            ,function(){

        Route::get('/set-fiscal-year','DashboardController@setFiscalYear');
        Route::get('/get-nepal-map-data','DashboardController@getNepalMapdata');
        Route::get('get-province-data', 'DashboardController@getProvinceData');
        Route::get('get-district-data', 'DashboardController@getDistrictData');
        Route::get('get-all-projects-on-local-level', 'DashboardController@getLocalLevelProjectsData');
        Route::get('get-geodata', 'DashboardController@getGeoData');

    });

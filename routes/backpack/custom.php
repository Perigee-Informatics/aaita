<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardCrudController;
use App\Http\Controllers\Admin\MemberCrudController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => 'public',
    'middleware' => ['XSS'],
    'namespace'  => 'App\Http\Controllers',
], function () { // custom admin routes
    Route::get('member/{member_id}/print-profile', [DashboardController::class,'printProfile']);
    // Route::post('get-members-list', [DashboardController::class,'getMembersList']);

    Route::get('list-members', [DashboardController::class,'tabularIndex']);
    Route::post('list-members', [DashboardController::class,'getMembersList']);
    Route::get('member/{member_id}/view-detailed-info', [DashboardController::class,'viewDetailedInfo']);
    Route::get('member/{member_id}/send-email-view', [DashboardController::class,'sendEmailView']);

    Route::post('member/{member_id}/send-email', [DashboardController::class,'sendEmail']);

    Route::crud('apply-for-membership','Admin\MemberCrudController');
    Route::post('apply-for-membership/store','Admin\MemberCrudController@store');
    Route::post('apply-for-membership/update_form','Admin\MemberCrudController@updateForm');
    Route::get('apply-for-membership/edit','Admin\MemberCrudController@editForm');
    Route::get('apply-for-membership/{mem_id}/confirm','Admin\MemberCrudController@submitConfirm');
});


Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web','XSS', config('backpack.base.middleware_key', 'admin')],
    // 'middleware' => array_merge(
    //     (array) config('backpack.base.web_middleware', 'web'),
    //     (array) config('backpack.base.middleware_key', 'admin'),
    // ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    // primary master routes
    Route::crud('country', 'CountryCrudController');
    Route::crud('mstfedprovince', 'MstFedProvinceCrudController');
    Route::crud('mstfeddistrict', 'MstFedDistrictCrudController');
    Route::crud('mstfedlocallevel', 'MstFedLocalLevelCrudController');
    Route::crud('mstfedlocalleveltype', 'MstFedLocalLevelTypeCrudController');
    Route::crud('mstfiscalyear', 'MstFiscalYearCrudController');
    Route::crud('mstnepalimonth', 'MstNepaliMonthCrudController');
    Route::crud('mstgender', 'MstGenderCrudController');


    Route::get('dashboard', 'DashboardCrudController@index')->name('dashboard');
    
    
    Route::crud('notification', 'NotificationCrudController');

    Route::get('list-members', [DashboardController::class,'tabularIndex']);
    Route::post('list-members', [DashboardController::class,'getMembersList']);

    


    Route::crud('member', 'MemberCrudController');
    Route::post('import-member', 'MemberCrudController@importMembers')->name('importMemberExcel');
    Route::get('member/{member_id}/print-profile', 'MemberCrudController@printProfile');
    Route::get('member/{member_id}/export-profile', 'MemberCrudController@exportProfile');
    Route::get('member/profiles/print-all', 'MemberCrudController@printAllProfiles');
    Route::get('member/profiles/export-all', 'MemberCrudController@exportAllProfiles');
    
    Route::get('member/send-mail','MemberCrudController@sendMail');
    
    Route::get('email_details', 'MemberCrudController@emailDetails');
}); // this should be the absolute last line of this file
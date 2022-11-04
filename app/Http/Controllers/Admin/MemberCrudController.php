<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\Country;
use App\Models\MstGender;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Base\Helpers\PdfPrint;
use App\Imports\MembersImport;
use App\Models\MstFedDistrict;
use App\Models\MstFedProvince;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Base\BaseCrudController;
use App\Models\MstFedLocalLevel;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;
use App\Http\Requests\MemberRequest;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MemberCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MemberCrudController extends BaseCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Member::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/member');
        CRUD::setEntityNameStrings('member', 'members');
        $this->setFilters();

        $this->data['script_js'] = $this->scriptJs();
        $this->data['style_css'] = $this->styleCss();
        if(in_array($this->crud->getActionMethod(),['edit','index'])){
            $this->crud->print_profile_btn = true;
        }
        $this->crud->set('show.setFromDb',false);

        if(Str::contains(url()->current(),'public')){
        $this->data['set_confirm_submit'] = true;

            $this->crud->operation(['create'], function () {
                $this->crud->loadDefaultOperationSettingsFromConfig();
                $this->crud->setupDefaultSaveActions();
                $this->crud->setOperationSetting('groupedErrors', false);
                $this->crud->setOperationSetting('inlineErrors', false);
            });

            $this->crud->operation(['preview','show'], function () {
                $this->crud->removeButton('edit');
                $this->crud->denyAccess('update');
                
                $this->crud->denyAccess('delete');
                $this->crud->removeButton('delete');
                $this->crud->denyAccess('list');
            });
        }
    }

    public function styleCss()
    {
        return "
        .form-group.required label:not(:empty)::after {
            content: ' *';
            color: #ff0000 !important;
        }
        ";
    }

    public function scriptJs()
    {
        return "
            $(document).ready(function(){
                $('.name_of_other_school').hide();
                showHideField($('#name_of_school').val());
                checkRequiredCondition();


                $('#name_of_school').on('change',function(){
                    showHideField($('#name_of_school').val());
                });

                $('.is_other_country').change(function(){
                    checkRequiredCondition();
                });

               
                //enable required fields validation on country status toggle
                function checkRequiredCondition()
                {
                    if($('#is_other_country_1').is(':checked')){
                        $('.required_0').addClass('required');
                        $('.required_0').find('select').attr('required','required');
                    }else{
                        $('.required_0').removeClass('required');
                        $('.required_0').find('select').removeAttr('required','required');
                    };

                    if($('#is_other_country_2').is(':checked')){
                            $('.required_1').addClass('required');
                            $('.required_1').find('select').attr('required','required');
                        }else{
                            $('.required_1').removeClass('required');
                            $('.required_1').find('select').removeAttr('required','required');

                    };
                }



                function showHideField(val){
                    if(val == 4){
                        $('.name_of_other_school').show();
                    }else{
                        $('.name_of_other_school').hide();
                    }
                }

                $('form').find('input, select, textarea,number,time').each(function () {
                    if ($(this).attr('required')) {
                        $(this).parent().addClass('required');
                        $(this).parent().parent().addClass('required');
                    }
                    
                });
            });
        ";
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */

    protected function setFilters()
    {
        $this->addProvinceIdFilter();
        $this->addDistrictIdFilter();
        $this->crud->addFilter(
            [ // simple filter
                'type' => 'select2',
                'name' => 'is_other_country',
                'label' => trans('Country'),
                'placeholder'=>'--choose--'
            ],
            [
                0 => 'Nepal',
                1 => 'Other',
            ],
            function ($value) { // if the filter is active
                if($value<2){
                    $this->crud->addClause('where', 'is_other_country', "$value");
                }
            }
        );

        $this->crud->addFilter(
            [ // simple filter
                'type' => 'select2',
                'name' => 'gender_id',
                'label' => trans('Gender'),
                'placeholder'=>'--choose--'

            ], function () {
                return MstGender::all()->pluck('name_en', 'id')->toArray();
            },
            function ($value) { // if the filter is active
                $this->crud->query->whereGenderId($value);
        });
        // $this->crud->addFilter(
        //     [ // simple filter
        //         'type' => 'select2',
        //         'name' => 'channel_wiw',
        //         'label' => trans('Channels'),
        //         'placeholder'=>'--choose--'
        //     ],
        //     [
        //         0 => 'Who Is Who',
        //         1 => 'Women Scientists Forum Nepal',
        //         2 => 'Foreign',
        //     ],
        //     function ($value) { // if the filter is active
        //         if($value == 0){
        //             $this->crud->addClause('where', 'channel_wiw', true);
        //         }
                
        //         if($value == 1){
        //             $this->crud->addClause('where', 'channel_wsfn', true);
        //         }

        //         if($value == 2){
        //             $this->crud->addClause('where', 'channel_foreign', true);
        //         }
        //     }
        // );
        // $this->crud->addFilter(
        //     [ // simple filter
        //         'type' => 'select2',
        //         'name' => 'membership_type',
        //         'label' => trans('Membership Type'),
        //         'placeholder'=>'--choose--'
        //     ],
        //     [
        //         'life' => 'Life',
        //         'friends_of_wsfn' => 'Friends of WSFN',
        //     ],
        //     function ($value) { // if the filter is active
        //         $this->crud->addClause('where', 'membership_type', "$value");
        //     }
        // );
        $this->crud->addFilter(
            [ // simple filter
                'type' => 'select2',
                'name' => 'status',
                'label' => trans('Status'),
                'placeholder'=>'--choose--'

            ],
            function () {
                return Member::$status;
            },
            
            function ($value) { // if the filter is active
                if($value){
                    $this->crud->addClause('where', 'status', "$value");
                }
            }
        );

    }


    protected function setupListOperation()
    {
        // $this->crud->addButtonFromView('top', 'excelImport', 'excelImport', 'end');
        
        // CRUD::setFromDb(); // columns
        $this->crud->addButtonFromView('line', 'print_profile', 'print_profile', 'beginning');
        $cols=[
            $this->addRowNumberColumn(),
            [   // Upload
                'name' => 'photo_path',
                'label' => trans('Photo'),
                'type' => 'image',
                'upload' => true,
                'disk' => 'uploads',
            ],
            [
                'name'=>'full_name',
                'type'=>'text',
                'label'=>'Full Name'
            ],

            [
                'name' => 'gender_id',
                'type' => 'select',
                'entity'=>'genderEntity',
                'attribute' => 'name_en',
                'model'=>MstGender::class,
                'label' => trans('Gender'),
            ],
            [
                'name'=>'dob_ad',
                'type'=>'model_function',
                'function_name'=>'dob',
                'label'=>'D.O.B (B.S/A.D)'
            ],

            // [
            //     'name'=>'nrn_number',
            //     'type'=>'text',
            //     'label'=>trans('NRN Number'),
            // ],
            // [
            //     'name'=>'channel_wiw',
            //     'label'=>trans('Is WIW ?'),
            //     'type'=>'check',
            // ],

            // [
            //     'name'=>'channel_wsfn',
            //     'label'=>trans('Is WSFN ?'),
            //     'type'=>'check',
            // ],
          
            // [
            //     'name'=>'channel_foreign',
            //     'label'=>trans('Is CHANNEL FOREIGN ?'),
            //     'type'=>'check',
            // ],
            // [
            //     'name'=>'membership_type',
            //     'label'=>'Membership Type',
            //     'type'=>'select_from_array',
            //     'options'=>[
            //         'life'=>'Life',
            //         'friends_of_wsfn'=>'Friends of WSFN'
            //     ]
            // ],

            [ //Toggle
                'name' => 'is_other_country',
                'label' => "Other".'<br>'."Country ?",
                'type' => 'radio',
                'options'     => [ 
                    0 => trans('No'),
                    1 => trans('Other'),
                ],
            ],
            [
                'name'=>'country_id',
                'type'=>'select',
                'label'=>trans("Country"),
                'entity'=>'currentCountryEntity',
                'model'=>Country::class,
                'attribute'=>'name_en',
            ],
            [
                'name'=>'province_id',
                'type'=>'select',
                'label'=>trans('Province'),
                'entity'=>'provinceEntity',
                'model'=>MstFedProvince::class,
                'attribute'=>'name_en',
            ],
            [
                'name'=>'district_id',
                'label'=>trans('District'),
                'type'=>'select',
                'model'=>MstFedDistrict::class,
                'entity'=>'districtEntity',
                'attribute'=>'name_en',
            ],
            [
                'name'  => 'current_organization',
                'label'   => '<center>Current Organization</center>',
                'type'  => 'custom_table',
                'columns' => [
                    'position'=> 'Position',
                    'organization' => 'Organization',
                    'address' => 'Address',
                ]
            ],
            // [
            //     'name'  => 'past_organization',
            //     'label'   => '<center>Past Organization</center>',
            //     'type'  => 'custom_table',
            //     'columns' => [
            //         'position'=> 'Position',
            //         'organization' => 'Organization',
            //         'address' => 'Address',
            //     ]
            // ],
            [
                'name'  => 'highest_degree',
                'label'   => '<center>Highest Degree</center>',
                'type'  => 'education_custom_table',
                'columns' => [
                    'degree_name'=> 'Academic Level',
                    'others_degree' => 'Others (If any)',
                    'subject_or_research_title' => 'Subject/Research Title',
                    'university_or_institution' => 'Name of University/Institution',
                    'country' => 'Address',
                    'year' => 'Year',
                ]
            ],
            [
                'name'  => 'ait_study_details',
                'label'   => '<center>AIT Study Details</center>',
                'type'  => 'ait_custom_table',
                'columns' => [
                    'academic_level'=> 'Academic level',
                    'name_of_degree' => 'Others (If any)',
                    'field_of_study' => 'Field of Study',
                    'graduation_year' => 'Graduation Year',
                ]
            ],
            // [
            //     'name'  => 'awards',
            //     'label'   => '<center> Awards</center>',
            //     'type'  => 'awards_custom_table',
            //     'columns' => [
            //         'award_name'=> 'Award Name',
            //         'awarded_by' => 'Awarded By',
            //         'awarded_year' => 'Year',
            //     ]
            // ],
            [
                'name'  => 'expertise',
                'label'   => '<center> Expertise</center>',
                'type'  => 'awards_custom_table',
                'columns' => [
                    'name'=> 'Name',
                ]
            ],
            // [
            //     'name'  => 'affiliation',
            //     'label'   => '<center> Affiliation</center>',
            //     'type'  => 'awards_custom_table',
            //     'columns' => [
            //         'name'=> 'Name',
            //     ]
            // ],
           
            [
                'name' => 'mailing_address',
                'label' => trans('Postal Address'),
                'type' => 'model_function',
                'function_name'=>'mailingAddress'
            ],
            [
                'name' => 'phone',
                'label' => trans('Phone/Cell'),
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => trans('E-mail'),
                'type' => 'text',
            ],
            [
                'name' => 'link_to_google_scholar',
                'label' => trans('Link to Google Scholar'),
                'type' => 'url',
            ],

        ];

        $this->crud->addColumns(array_filter($cols));
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(MemberRequest::class);

        $status = NULL;

        if(backpack_user()){
            $status =    [
                'name'=>'status',
                'label'=>'Status',
                'type'=>'select_from_array',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
                'options'=>Member::$status
            ];
        }

        $arr=[
            [
                'name' => 'legend1',
                'type' => 'custom_html',
                'value' => '<legend>Personal Information</legend><hr class="m-0">',
            ],

            [
                'name' => 'full_name',
                'label' => trans('Full Name'),
                'type' => 'text',
                'attributes'=>[
                    'id' => 'name-en',
                    'required' => 'required',
                    'max-length'=>200,
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-7',
                ],
            ],
            [
                'name' => 'gender_id',
                'type' => 'select2',
                'entity'=>'genderEntity',
                'attribute' => 'name_en',
                'model'=>MstGender::class,
                'label' => trans('Gender'),
                'wrapper' => [
                    'class' => 'form-group col-md-5',
                ],
                'attributes'=>[
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'email',
                'label' => trans('E-mail'),
                'type' => 'text',
                'attributes'=>[
                    'max-length'=>500,
                    'required' => 'required',
                ],
                'prefix'=>'<i class="la la-at"></i>',
                'wrapper' => [
                    'class' => 'form-group col-md-7',
                ],
            ],
            [
                'name' => 'phone',
                'label' => trans('Phone/Cell'),
                'type' => 'text',
                'attributes'=>[
                    'max-length'=>200,
                ],
                'prefix'=>'<i class="la la-mobile"></i>',
                'wrapper' => [
                    'class' => 'form-group col-md-5',
                ],
            ],
        

            [
                'name' => 'dob_bs',
                'type' => 'nepali_date',
                'label' => trans('D.O.B (B.S.)'),
                'attributes'=>[
                    'id'=>'date_bs',
                    'relatedId'=>'dob_ad',
                    'maxlength' =>10,

                ],
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'dob_ad',
                'type' => 'date',
                'label' => trans('D.O.B  (A.D.)'),
                'attributes'=>[
                    'id'=>'dob_ad',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],

            [   // Upload
                'name' => 'photo_path',
                'label' => trans('Photo'),
                'type' => 'image',
                'upload' => true,
                'disk' => 'uploads',
                'crop'=>true, 
                'aspect_ratio'=>1,
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'mailing_address',
                'label' => trans('Current Postal Address'),
                'type' => 'text',
                'attributes'=>[
                    'max-length'=>500,
                    'required' => 'required',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-12',
                ],
            ],
            [
                'name' => 'legend2',
                'type' => 'custom_html',
                'value' => '<legend>Permanent Address</legend><hr class="m-0">',
            ],
            [
                'name'=>'province_id',
                'type'=>'select2',
                'label'=>trans('Province'),
                'entity'=>'provinceEntity',
                'model'=>MstFedProvince::class,
                'attribute'=>'name_en',
                'attributes'=>[
                    'required' => 'required',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name'=>'district_id',
                'label'=>trans('District'),
                'type'=>'select2_from_ajax',
                'model'=>MstFedDistrict::class,
                'entity'=>'districtEntity',
                'attribute'=>'name_en',
                'data_source' => url("api/district/province_id"),
                'placeholder' => "Select District",
                'minimum_input_length' => 0,
                'dependencies'         => ['province_id'],
                'include_all_form_fields'=>true,
                'method'=>'POST',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
                'attributes'=>[
                    'required' => 'required',
                ],
            ],
            [
                'name'=>'local_level_id',
                'label'=>trans('Local Level'),
                'type'=>'select2_from_ajax',
                'model'=>MstFedLocalLevel::class,
                'entity'=>'localLevelEntity',
                'attribute'=>'name_en',
                'data_source' => url("api/locallevel/district_id"),
                'placeholder' => "Select Local Level",
                'minimum_input_length' => 0,
                'dependencies'         => ['district_id'],
                'include_all_form_fields'=>true,
                'method'=>'POST',
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'attributes'=>[
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'ward',
                'label' => trans('Ward'),
                'type' => 'number',
                'attributes'=>[
                    'max-length'=>2,
                    'required' => 'required',
                ],
                'default'=>0,
                'wrapper' => [
                    'class' => 'form-group col-md-2',
                ],
            ],
            [
                'name' => 'legend3',
                'type' => 'custom_html',
                'value' => '<legend>Residential Address</legend><hr class="m-0">',
            ],
            [ //Toggle
                'name' => 'is_other_country',
                'label' => trans('Is Current Country Nepal ?'),
                'type' => 'toggle',
                'options'     => [ 
                    0 => trans('Nepal'),
                    1 => trans('Abroad'),
                ],
                'inline' => true,
                'wrapper' => [
                    'class' => 'form-group col-md-12 is_other_country',
                ],
                'attributes' =>[
                    'id' => 'is_other_country',
                ],
                'hide_when' => [
                    0 => ['current_country_id','city_of_residence'],
                    1 => ['current_province_id','current_district_id','current_local_level_id','current_ward','custom_html_1'],
                ],
                'default' => 0,
            ],
         
            [
                'name'=>'current_province_id',
                'type'=>'select2',
                'label'=>trans('Province'),
                'entity'=>'currentProvinceEntity',
                'model'=>MstFedProvince::class,
                'attribute'=>'name_en',
                'wrapper' => [
                    'class' => 'form-group col-md-3 required_0',
                ],
            ],
            [
                'name'=>'current_district_id',
                'label'=>trans('District'),
                'type'=>'select2_from_ajax',
                'model'=>MstFedDistrict::class,
                'entity'=>'currentDistrictEntity',
                'attribute'=>'name_en',
                'data_source' => url("api/district/current_province_id"),
                'placeholder' => "Select District",
                'minimum_input_length' => 0,
                'dependencies'         => ['current_province_id'],
                'include_all_form_fields'=>true,
                'method'=>'POST',
                'wrapper' => [
                    'class' => 'form-group col-md-3 required_0',
                ],

            ],
            [
                'name'=>'current_local_level_id',
                'label'=>trans('Local Level'),
                'type'=>'select2_from_ajax',
                'model'=>MstFedLocalLevel::class,
                'entity'=>'currentLocalLevelEntity',
                'attribute'=>'name_en',
                'data_source' => url("api/locallevel/current_district_id"),
                'placeholder' => "Select Local Level",
                'minimum_input_length' => 0,
                'dependencies'         => ['current_district_id'],
                'include_all_form_fields'=>true,
                'method'=>'POST',
                'wrapper' => [
                    'class' => 'form-group col-md-4 required_0',
                ],
            ],
            [
                'name' => 'current_ward',
                'label' => trans('Ward'),
                'type' => 'number',
                'attributes'=>[
                    'max-length'=>2,
                ],
                'default'=>0,
                'wrapper' => [
                    'class' => 'form-group col-md-2 required_0',
                ],
            ],
            [
                'name'=>'current_country_id',
                'type'=>'select2',
                'label'=>trans("Current Country of Residence"),
                'entity'=>'currentCountryEntity',
                'model'=>Country::class,
                'attribute'=>'name_en',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 required_1',
                ],
                'default'=>153
            ],
            [
                'name' => 'city_of_residence',
                'label' => trans('City of Residence'),
                'type' => 'text',
                'attributes'=>[
                    'max-length'=>500,
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6 required_1',
                ],
            ],
            [
                'name' => 'legend4',
                'type' => 'custom_html',
                'value' => '<legend>Academic Details</legend><hr class="m-0">',
            ],
          
            [
                'name'  => 'highest_degree',
                'label'   => trans('Highest Degree Awarded So Far'),
                'type'  => 'repeatable_with_action',
                'fields' => [
                    [
                        'name'    => 'degree_name',
                        'type'    => 'select_from_array',
                        'options'=>Member::$degree_options,
                        'label'   => trans('Academic Level'),
                        'wrapper' => ['class' => 'form-group col-md-4'],
                        'required' => true
                    ],
                    [
                        'name'    => 'others_degree',
                        'type'    => 'text',
                        'label'   => trans('Other degree(If any)'),
                        'wrapper' => ['class' => 'form-group col-md-4'],
                        'required' => true
                    ],
                    [
                        'name'    => 'subject_or_research_title',
                        'type'    => 'text',
                        'label'   => trans('Subject/Research Title'),
                        'wrapper' => ['class' => 'form-group col-md-4'],
                        'required' => true
                    ],
                    [
                        'name'    => 'university_or_institution',
                        'type'    => 'text',
                        'label'   => trans('Name of University/Institution'),
                        'wrapper' => ['class' => 'form-group col-md-6'],
                        'required' => true
                    ],
                    [
                        'name'    => 'country',
                        'type'    => 'text',
                        'label'   => trans('Country'),
                        'wrapper' => ['class' => 'form-group col-md-3'],
                        'required' => true
                    ],
                    [
                        'name'    => 'year',
                        'type'    => 'number',
                        'label'   => trans('Year (A.D.)'),
                        'wrapper' => ['class' => 'form-group col-md-3'],
                        'suffix'=>'A.D.',
                        'required' => true
                    ],
                ],
                'min_rows' => 1,
                'max_rows'=>1
            ],
            [
                'name'  => 'ait_study_details',
                'label'   => trans('Latest AIT Study Details'),
                'type'  => 'repeatable_with_action',
                'fields' => [
                    [
                        'name'    => 'academic_level',
                        'type'    => 'select_from_array',
                        'options'=>Member::$degree_options,
                        'label'   => trans('Academic Level'),
                        'wrapper' => ['class' => 'form-group col-md-4'],
                        'required' => true
                    ],
                    [
                        'name'    => 'name_of_degree',
                        'type'    => 'text',
                        'label'   => trans('Name of Degree'),
                        'wrapper' => ['class' => 'form-group col-md-8'],
                        'required' => true
                    ],
                    [
                        'name'    => 'name_of_school',
                        'type'    => 'select_from_array',
                        'label'   => trans('School'),
                        'wrapper' => ['class' => 'form-group col-md-6'],
                        'options'=>Member::$school_options,
                        'attributes'=>['id'=>'name_of_school'],
                        'required' => true
                    ],
                    [
                        'name'    => 'name_of_other_school',
                        'type'    => 'text',
                        'label'   => 'School Name <sub class="text-danger">(Please specify if other school !!)</sub>',
                        'wrapper' => ['class' => 'form-group col-md-6 name_of_other_school'],
                        'attributes'=>['id'=>'name_of_other_school'],
                    ],
                    [
                        'name'    => 'field_of_study',
                        'type'    => 'text',
                        'label'   => trans('Field of Study / Division / Department / Program'),
                        'wrapper' => ['class' => 'form-group col-md-8'],
                        'required' => true
                    ],
                    [
                        'name'    => 'graduation_year',
                        'type'    => 'number',
                        'label'   => trans('Graduation Year (A.D.)'),
                        'wrapper' => ['class' => 'form-group col-md-4'],
                        'suffix'=>'A.D.',
                        'required' => true
                    ],
                ],
                'min_rows' => 1,
                'max_rows'=>1
            ],
            [
                'name' => 'legend5',
                'type' => 'custom_html',
                'value' => '<legend>Profession and Expertise</legend><hr class="m-0">',
            ],

            [
                'name'  => 'current_organization',
                'label'   => trans('Current Organization'),
                'type'  => 'repeatable_with_action',
                'fields' => [
                    [
                        'name'    => 'position',
                        'type'    => 'text',
                        'label'   => trans('Position'),
                        'wrapper' => ['class' => 'form-group col-md-4'],
                        'required' => true
                    ],
                    [
                        'name'    => 'organization',
                        'type'    => 'text',
                        'label'   => trans('Organization'),
                        'wrapper' => ['class' => 'form-group col-md-8'],
                        'required' => true
                    ],
                    [
                        'name'    => 'address',
                        'type'    => 'text',
                        'label'   => trans('Address'),
                        'wrapper' => ['class' => 'form-group col-md-4'],
                        'required' => true
                    ],
                    [
                        'name'    => 'from',
                        'type'    => 'text',
                        'label'   => trans('From Year (A.D.)'),
                        'wrapper' => ['class' => 'form-group col-md-4'],
                        'suffix'=>'A.D.',
                        'required' => true
                    ],
                    [
                        'name'    => 'is_founder',
                        'type'    => 'checkbox',
                        'label'   => '<b>Self-employed (Co-Founder)</b>',
                        'wrapper' => ['class' => 'form-group col-md-4 mt-4 pt-2 pl-5'],
                        'required' => true,
                    ],
                ],
                'min_rows' => 1,
                'max_rows' => 1,
            ],
            [
                'name'  => 'past_organization',
                'label'   => trans('Past Organization'),
                'type'  => 'repeatable_with_action',
                'fields' => [
                    [
                        'name'    => 'position',
                        'type'    => 'text',
                        'label'   => trans('Position'),
                        'wrapper' => ['class' => 'form-group col-md-4'],
                        'required' => true
                    ],
                    [
                        'name'    => 'organization',
                        'type'    => 'text',
                        'label'   => trans('Organization'),
                        'wrapper' => ['class' => 'form-group col-md-8'],
                        'required' => true
                    ],
                    [
                        'name'    => 'address',
                        'type'    => 'text',
                        'label'   => trans('Address'),
                        'wrapper' => ['class' => 'form-group col-md-4'],
                        'required' => true
                    ],
                    [
                        'name'    => 'from',
                        'type'    => 'number',
                        'label'   => trans('From Year'),
                        'suffix'=>'A.D.',
                        'wrapper' => ['class' => 'form-group col-md-4'],
                        'required' => true
                    ],
                    [
                        'name'    => 'to',
                        'type'    => 'number',
                        'label'   => trans('To Year'),
                        'suffix'=>'A.D.',
                        'wrapper' => ['class' => 'form-group col-md-4'],
                        'required' => true
                    ],
                ],
                'min_rows' => 1,
            ],
            [
                'name'=>'custom_div_row_open',
                'fake'=>true,
                'type'=>'plain_html',
                'value'=>'<div class="form-row" style="width:100%">'
            ],
            [
                'name'=>'custom_div_col_1_open',
                'fake'=>true,
                'type'=>'plain_html',
                'value'=>'<div class="col-md-6">'
            ],
           
            [
                'name'  => 'expertise',
                'label'   => trans('Expertise <sub class="text-danger">(Please specify one expertise in one box !!)</sub>'),
                'type'  => 'repeatable_with_action',
                'wrapper'=>[
                    'class'=>'col-md-12'
                ],
                'fields' => [
                    [
                        'name'    => 'name',
                        'type'    => 'text',
                        'label'   => trans('Expertise Area'),
                        'wrapper' => ['class' => 'form-group col-md-12'],
                        'required' => true
                    ],
                ],
                'min_rows' => 3,
            ],
            [
                'name'=>'custom_div_col_1_close',
                'fake'=>true,
                'type'=>'plain_html',
                'value'=>'</div>'
            ],
            [
                'name'=>'custom_div_col_2_open',
                'fake'=>true,
                'type'=>'plain_html',
                'value'=>'<div class="col-md-6">'
            ],
          
           
            [   // Upload
                'name' => 'document_path',
                'label' => trans('Upload a proof for your student affiliation/graduation from AIT'),
                'type' => 'upload_multiple',
                'upload' => true,
                'disk' => 'uploads',
                'wrapper' => [
                    'class' => 'form-group col-md-12 pl-5 pt-5',
                ],
            ],
            [
                'name'=>'custom_div_col_2_close',
                'fake'=>true,
                'type'=>'plain_html',
                'value'=>'</div>'
            ],
            [
                'name'=>'custom_div_row_close',
                'fake'=>true,
                'type'=>'plain_html',
                'value'=>'</div>'
            ],
            [
                'name'=>'custom_html_2',
                'fake'=>true,
                'type'=>'custom_html',
                'value'=>'</br>'
            ],

            [
                'name' => 'link_to_google_scholar',
                'label' => trans('Google Scholar Link'),
                'type' => 'url',
                'attributes'=>[
                    'max-length'=>100,
                ],
                'prefix'=>'<i class="la la-globe"></i>',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'linkedin_profile_link',
                'label' => trans('LinkedIn Profile Link'),
                'type' => 'url',
                'attributes'=>[
                    'max-length'=>100,
                ],
                'prefix'=>'<i class="la la-globe"></i>',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'bio',
                'label' => trans('Short Bio (500 characters)'),
                'type' => 'textarea',
                'attributes'=>[
                    'maxlength'=>500,
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-12',
                ],
            ],
            $status
         

        ];
        $this->crud->addFields(array_filter($arr));

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

    protected function setupShowOperation()
    {
        $columns=[
            [   // Upload
                'name' => 'photo_path',
                'label' => trans('Photo'),
                'type' => 'image',
                'upload' => true,
                'disk' => 'uploads',
            ],
            [
                'name'=>'full_name',
                'type'=>'text',
                'label'=>'Full Name'
            ],

            [
                'name' => 'gender_id',
                'type' => 'select',
                'entity'=>'genderEntity',
                'attribute' => 'name_en',
                'model'=>MstGender::class,
                'label' => trans('Gender'),
            ],
            [
                'name' => 'email',
                'label' => trans('E-mail'),
                'type' => 'text',
            ],
            [
                'name' => 'phone',
                'label' => trans('Phone/Cell'),
                'type' => 'text',
            ],
            [
                'name'=>'dob_ad',
                'type'=>'model_function',
                'function_name'=>'dob',
                'label'=>'D.O.B (B.S/A.D)'
            ],
            [
                'name' => 'mailing_address',
                'label' => trans('Current Postal Address'),
                'type' => 'text',
            ],
            [
                'name' => 'permanent_address',
                'type' => 'custom_html',
                'value' => '<legend>Permanent Address</legend><hr class="m-0">',
            ],

            [
                'name'=>'province_id',
                'type'=>'select',
                'label'=>trans('Province'),
                'entity'=>'provinceEntity',
                'model'=>MstFedProvince::class,
                'attribute'=>'name_en',
            ],
            [
                'name'=>'district_id',
                'label'=>trans('District'),
                'type'=>'select',
                'model'=>MstFedDistrict::class,
                'entity'=>'districtEntity',
                'attribute'=>'name_en',
            ],
            [
                'name'=>'local_level_id',
                'label'=>trans('Local Level'),
                'type'=>'select',
                'model'=>MstFedLocalLevel::class,
                'entity'=>'localLevelEntity',
                'attribute'=>'name_en',
         
            ],
            [
                'name' => 'ward',
                'label' => trans('Ward'),
                'type' => 'number',
            ],
      
            [
                'name' => 'Residential Address',
                'type' => 'custom_html',
                'value' => '<legend>Residential Address</legend><hr class="m-0">',
            ],
            [ //Toggle
                'name' => 'is_other_country',
                'label' => trans('Is Current Country Nepal ?'),
                'type' => 'boolean',
                'options'     => [ 
                    false => trans('YES'),
                    true => trans('NO'),
                ],
            ],
         
            [
                'name'=>'current_province_id',
                'type'=>'select',
                'label'=>trans('Province'),
                'entity'=>'currentProvinceEntity',
                'model'=>MstFedProvince::class,
                'attribute'=>'name_en',
            ],
            [
                'name'=>'current_district_id',
                'label'=>trans('District'),
                'type'=>'select',
                'model'=>MstFedDistrict::class,
                'entity'=>'currentDistrictEntity',
                'attribute'=>'name_en',
            ],
            [
                'name'=>'current_local_level_id',
                'label'=>trans('Local Level'),
                'type'=>'select',
                'model'=>MstFedLocalLevel::class,
                'entity'=>'currentLocalLevelEntity',
                'attribute'=>'name_en',
            ],
            [
                'name' => 'current_ward',
                'label' => trans('Ward'),
                'type' => 'number',
            ],
            [
                'name'=>'current_country_id',
                'type'=>'select',
                'label'=>trans("Current Country of Residence"),
                'entity'=>'currentCountryEntity',
                'model'=>Country::class,
                'attribute'=>'name_en',
            ],
            [
                'name' => 'city_of_residence',
                'label' => trans('City of Residence'),
                'type' => 'text',
            ],
            [
                'name' => 'Academic Details',
                'type' => 'custom_html',
                'value' => '<legend>Academic Details</legend><hr class="m-0">',
            ],
            [
                'name'  => 'highest_degree',
                'label'   => trans('Highest Degree Awarded So Far'),
                'type'  => 'education_custom_table',
                'columns' => [
                    'degree_name'=> 'Academic Level',
                    'others_degree' => 'Others (If any)',
                    'subject_or_research_title' => 'Subject/Research Title',
                    'university_or_institution' => 'Name of University/Institution',
                    'country' => 'Country',
                    'year' => 'Year(A.D.)',
                ]
                   
            ],
            [
                'name'  => 'ait_study_details',
                'label'   => trans('Latest AIT Study Details'),
                'type'  => 'ait_study_details',
                'columns' => [
                    'academic_level'=> 'Academic Level',
                    'name_of_degree' => 'Name of Degree',
                    'name_of_school' => 'Name of School',
                    'name_of_other_school' => 'Name of Other School(If any)',
                    'field_of_study' => 'Field of Study / Division / Department / Program',
                    'graduation_year' => 'Graduation Year(A.D.)',
                ]
            ],
            [
                'name' => 'Profession and Expertise',
                'type' => 'custom_html',
                'value' => '<legend>Profession and Expertise</legend><hr class="m-0">',
            ],

            [
                'name'  => 'current_organization',
                'label'   => 'Current Organization',
                'type'  => 'custom_table',
                'columns' => [
                    'position'=> 'Position',
                    'organization' => 'Organization',
                    'address' => 'Address',
                    'from' => 'From Year (A.D.)',
                    'is_founder'=>'Self-employed (Co-Founder)'
                ]
            ],
            [
                'name'  => 'past_organization',
                'label'   => 'Past Organization',
                'type'  => 'custom_table',
                'columns' => [
                    'position'=> 'Position',
                    'organization' => 'Organization',
                    'address' => 'Address',
                    'from' => 'From Year (A.D.)',
                    'to' => 'To Year (A.D.)',
                ]
            ],
            [
                'name'  => 'highest_degree',
                'label'   => '<center>Highest Degree</center>',
                'type'  => 'education_custom_table',
                'columns' => [
                    'degree_name'=> 'Academic Level',
                    'others_degree' => 'Others (If any)',
                    'subject_or_research_title' => 'Subject/Research Title',
                    'university_or_institution' => 'Name of University/Institution',
                    'country' => 'Address',
                    'year' => 'Year',
                ]
            ],
            [
                'name'  => 'ait_study_details',
                'label'   => '<center>AIT Study Details</center>',
                'type'  => 'ait_custom_table',
                'columns' => [
                    'academic_level'=> 'Academic level',
                    'name_of_degree' => 'Others (If any)',
                    'field_of_study' => 'Field of Study',
                    'graduation_year' => 'Graduation Year',
                ]
            ],
           
            [
                'name'  => 'expertise',
                'label'   => 'Expertise',
                'type'  => 'awards_custom_table',
                'columns' => [
                    'name'=> 'Name',
                ]
            ],
            [   // Upload
                'name' => 'document_path',
                'label' => trans('Upload a proof for your student affiliation/graduation from AIT'),
                'type' => 'upload_multiple',
                'upload' => true,
                'disk' => 'uploads',
                'wrapper' => [
                    'class' => 'form-group col-md-12 pl-5 pt-5',
                ],
            ],
            [
                'name' => 'link_to_google_scholar',
                'label' => trans('Link to Google Scholar'),
                'type' => 'url',
            ],
            [
                'name' => 'linkedin_profile_link',
                'label' => trans('LinkedIn Profile Link'),
                'type' => 'url',
            ],
            [
                'name' => 'bio',
                'label' => trans('Short Bio'),
                'type' => 'textarea',
            ],
        ];

        $this->crud->addColumns(array_filter($columns));

    }

    public function editForm(Request $request){
        $token = $request->token;
        if($token != ''){
            $member = Member::where('token',$token)->first();

            if($member){
            $this->crud->allowAccess('update');
            $this->setupUpdateOperation();
            
            $this->crud->setOperationSetting('groupedErrors', false);
            $this->crud->setOperationSetting('inlineErrors', false);
            $this->crud->setOperationSetting('fields', $this->crud->getUpdateFields($member->id));
            

            $this->crud->public_update = true;

            $this->data['entry'] = $this->crud->getEntry($member->id);
            $this->data['crud'] = $this->crud;
            $this->data['update_url'] = 'public/apply-for-membership/update_form';
           
            $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.edit').' '.$this->crud->entity_name;

            $this->data['id'] = $member->id;
            // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
            return view('vendor.backpack.crud.edit', $this->data);
            }else{
                return view('errors.404');
            }

        }
    }

    

    public function store()
    {
        // $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        $request->request->set('status',1);

        if($request->get('dob_ad')==""){
            $request->request->set('dob_ad',NULL);
        }

        if($request->request->get('is_other_country') == '0')
        {
            $request->request->set('current_country_id',NULL);
            
        }else{
            $request->request->set('current_province_id',NULL);
            $request->request->set('current_district_id',NULL);
            $request->request->set('current_local_level_id',NULL);
        }

        $bytes = random_bytes(20);
        
        $request->request->set('token',bin2hex($bytes));
        $request = $request->except(['_token','http_referrer','save_action']);
        
        //check if record already exists
        $record_exists = Member::where([['email',$request['email']],['full_name',$request['full_name']]])->first();

        if($record_exists != null){
            return redirect('/public/apply-for-membership/'.$record_exists->id.'/show');
        }

        // insert item in the db
        $item = $this->crud->create($request);
        $this->data['entry'] = $this->crud->entry = $item;

        $this->sendFormSubmissionEmail($item);

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        
        if(backpack_user()){
            $this->crud->setSaveAction();
            return $this->crud->performSaveAction($item->getKey());
        }else{
            return redirect('/public/apply-for-membership/'.$item->id.'/show');
        }

    }

    public function updateForm()
    {
        $request = $this->crud->validateRequest();

        $token = $request->request->get('token');
        if($token != ''){
            $member = Member::where('token',$token)->first();
        }

        if($request->get('dob_ad')==""){
            $request->request->set('dob_ad',NULL);
        }

        $request->request->set('status',1);

        if($request->request->get('is_other_country') == '0')
        {
            $request->request->set('current_country_id',NULL);
            
        }else{
            $request->request->set('current_province_id',NULL);
            $request->request->set('current_district_id',NULL);
            $request->request->set('current_local_level_id',NULL);
        }

        $request = $request->except(['_token','http_referrer','save_action']);
        
        // update the row in the db
        $item = $this->crud->update($member->id,$request);

        return redirect('/public/apply-for-membership/'.$member->id.'/show');

    }

    public function submitConfirm($id)
    {
        Member::whereId($id)->update(['is_agreed_and_submitted'=>true]);

        return response()->json(['status'=>'true']);
    }


    public function importMembers(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'excelMemberFile' => 'required',
        ]);

        try {
            $itemImport = new MembersImport;
            Excel::import($itemImport, request()->file('excelMemberFile'));
            return 1;
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $excel_errors = $e->failures();
            return view('partial_excel_barcode_errors', compact('excel_errors'));
        }
	}


    public function printProfile($id,$public_view = false){
        $member = Member::find($id);

        $json_data = [
            'current_organization' => json_decode($member->current_organization),
            'past_organization' => json_decode($member->past_organization),
            'highest_degree' => json_decode($member->highest_degree),
            'ait_study_details' => json_decode($member->ait_study_details),
            'expertise' => json_decode($member->expertise),
        ];

        $photo_encoded = "";
        $photo_path = public_path('storage/uploads/'.$member->photo_path);
        // Read image path, convert to base64 encoding
        if($member->photo_path){
            $imageData = base64_encode(file_get_contents($photo_path));
            $photo_encoded = 'data:'.mime_content_type($photo_path).';base64,'.$imageData;
        }

        $data['member']['basic'] = $member;
        $data['member']['json_data'] = $json_data;
        $data['member']['photo_encoded'] = $photo_encoded;

        // Format the image SRC:  data:{mime};base64,{data};
        // dd($photo_encoded);
        // $pdf = Pdf::loadView('profile.individual_profile',compact('data','public_view') );
        // return $pdf->stream();

        $html = view('profile.individual_profile_jsreport', compact('data','public_view'))->render();
        PdfPrint::printPortrait($html, $member->full_name."_Profile.pdf"); 
    }

    public function printAllProfiles()
    {
        $data = [];
        foreach(Member::all() as $member)
        {
            $json_data = [
                'current_organization' => json_decode($member->current_organization),
                'past_organization' => json_decode($member->past_organization),
                'highest_degree' => json_decode($member->highest_degree),
                'ait_study_details' => json_decode($member->ait_study_details),
                'expertise' => json_decode($member->expertise),
            ];
    
            $photo_encoded = "";
            $photo_path = public_path('storage/uploads/'.$member->photo_path);
            // Read image path, convert to base64 encoding
            if($member->photo_path){
                $imageData = base64_encode(file_get_contents($photo_path));
                $photo_encoded = 'data: '.mime_content_type($photo_path).';base64,'.$imageData;
            }

            $data[$member->id]['basic'] = $member;
            $data[$member->id]['json_data'] = $json_data;
            $data[$member->id]['photo_encoded'] = $photo_encoded;
    
        }
        $public_view= false;

        // $pdf = Pdf::loadView('profile.individual_profile',compact('data','public_view') );
        // return $pdf->stream();

        $html = view('profile.individual_profile_jsreport', compact('data','public_view'))->render();
        PdfPrint::printPortrait($html,"Who_is_who_Profile.pdf"); 
    }


    public function emailDetails()
    {
        $datas = DB::table('email_details')->get();

        return view('admin.email_details',compact('datas'));
    }

    public function sendFormSubmissionEmail($member)
    {
        $member_email = $member->email;
        $member_fullname = $member->full_name;

        if(Str::contains($member_email,';')){
            $explode = explode(';',$member_email);
            $member_email= $explode[0];
        }
        $status = true;
        $msg= '';

        Mail::send('public.sendMail.form-submission-mail',compact('member'), function($message)use($member_email) {
            $message->to($member_email)
            ->from(env('MAIL_USERNAME'))
            ->subject('AITAAN -(WHO is WHO) -- Form submission successful');
        });

        if(Mail::failures() ) {
            $status=false;
            $msg = "Some error occured. Please contact administrator !! <br />";
         
         } 

        return response()->json(['status'=>$status,'msg'=>$msg]);

    }

    public function sendMail()
    {
        $members = Member::whereNull('token')->get();
        foreach($members as $member){
               Member::whereId($member->id)->update(['token'=>bin2hex(random_bytes(20))]);
               $new_m=Member::find($member->id);
               $this->sendFormSubmissionEmail($new_m);
        }
        return redirect(backpack_url('dashboard'));
    }
}

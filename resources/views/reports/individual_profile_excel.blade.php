<html>
    <body>
        <table>
            <tr>
                <th colspan="2" style="font-weight: bold; background:#e1e1e1;text-align: center; font-size:15px">AITAA Nepal</th>
            </tr>
             <tr>
                <th colspan="2" style="font-weight: bold; background:#e1e1e1;text-align: center; font-size:15px"></th>
            </tr>
         
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Full Name</td>
                <td style="border: 3px solid black;">{{$member['basic']->full_name}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Gender</td>
                <td style="border: 3px solid black;">{{$member['basic']->genderEntity->name_en}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">E-mail</td>
                <td style="border: 3px solid black;">{{$member['basic']->email}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Phone / Cell</td>
                <td style="border: 3px solid black;">{{$member['basic']->phone}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Date of Birth(B.S / A.D)</td>
                <td style="border: 3px solid black;">{{$member['basic']->dob_bs}} / {{$member['basic']->dob_ad}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Current Postal Address</td>
                <td style="border: 3px solid black;">{{$member['basic']->mailing_address}}</td>
            </tr>
       
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Permanent Address</td>
                <td style="border: 3px solid black;">{{$member['basic']->provinceEntity->name_en}}<br/>
                                                                            {{$member['basic']->districtEntity->name_en}}<br/>
                                                                            {{$member['basic']->localLevelEntity->name_en}}<br/>
                                                                            {{$member['basic']->ward}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Temporary Address</td>
                @if($member['basic']->is_other_country)
                    <td style="border: 3px solid black;">{{$member['basic']->currentCountryEntity->name_en}}<br/>
                                                        {{$member['basic']->city_of_residence}}</td>
                @else
                    <td style="border: 3px solid black;">{{$member['basic']->currentProvinceEntity->name_en}}<br/>
                                                        {{$member['basic']->currentDistrictEntity->name_en}}<br/>
                                                        {{$member['basic']->currentLocalLevelEntity->name_en}}<br/>
                                                        {{$member['basic']->ward}}</td>
                @endif                                                            
            </tr>
          {{-- highest study details --}}
            <tr>
                <th colspan="2" style="font-weight: bold; background:#e1e1e1;text-align: center; font-size:15px"></th>
            </tr>
            <tr>
                <th colspan="2" style="font-weight: bold; background:#e1e1e1;text-align: center; font-size:15px">Highest Degree Awarded</th>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Academic Level</td>
                <td style="border: 3px solid black;">{{ App\Models\Member::$degree_options[$member['json_data']['highest_degree'][0]->degree_name]}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">University / Institution</td>
                <td style="border: 3px solid black;">{{ $member['json_data']['highest_degree'][0]->university_or_institution}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Subject / Research Title</td>
                <td style="border: 3px solid black;">{{ $member['json_data']['highest_degree'][0]->subject_or_research_title}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Country, Year</td>
                <td style="border: 3px solid black;">{{ $member['json_data']['highest_degree'][0]->country}},{{$member['json_data']['highest_degree'][0]->year}}</td>
            </tr>
        
            {{-- AIT study details --}}
            <tr>
                <th colspan="2" style="font-weight: bold; background:#e1e1e1;text-align: center; font-size:15px"></th>
            </tr>
            <tr>
                <th colspan="2" style="font-weight: bold; background:#e1e1e1;text-align: center; font-size:15px">Latest AIT Study Details</th>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Academic Level</td>
                <td style="border: 3px solid black;">{{ App\Models\Member::$degree_options[$member['json_data']['ait_study_details'][0]->academic_level]}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Name of Degree</td>
                <td style="border: 3px solid black;">{{ $member['json_data']['ait_study_details'][0]->name_of_degree}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">School</td>
                @php
                $school='';
                    if($member['json_data']['ait_study_details'][0]->name_of_school == "4"){
                        $school = ' Other ('.$member['json_data']['ait_study_details'][0]->name_of_other_school.')';
                    }else{
                        $school =  App\Models\Member::$school_options[$member['json_data']['ait_study_details'][0]->name_of_school];
                    }
                @endphp
                <td style="border: 3px solid black;">{{ $school }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Field of Study / Division / Department / Program</td>
                <td style="border: 3px solid black;">{{ $member['json_data']['ait_study_details'][0]->field_of_study}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Graduation Year</td>
                <td style="border: 3px solid black;">{{$member['json_data']['ait_study_details'][0]->graduation_year}}</td>
            </tr>
{{-- current_organization --}}
            <tr>
                <th colspan="2" style="font-weight: bold; background:#e1e1e1;text-align: center; font-size:15px"></th>
            </tr>
            <tr>
                <th colspan="2" style="font-weight: bold; background:#e1e1e1;text-align: center; font-size:15px">Current Organization</th>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Position</td>
                <td style="border: 3px solid black;">{{$member['json_data']['current_organization'][0]->position}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Organization</td>
                <td style="border: 3px solid black;">{{$member['json_data']['current_organization'][0]->organization}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Adress</td>
                <td style="border: 3px solid black;">{{$member['json_data']['current_organization'][0]->address}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">From</td>
                <td style="border: 3px solid black;">{{$member['json_data']['current_organization'][0]->from}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Self-employed (Co-founder)</td>
                <td style="border: 3px solid black;">{{ $member['json_data']['current_organization'][0]->is_founder == "0" ? 'No' : 'Yes'}}</td>
            </tr>

            {{-- past experiences --}}
            <tr>
                <th colspan="2" style="font-weight: bold; background:#e1e1e1;text-align: center; font-size:15px"></th>
            </tr>
            <tr>
                <th colspan="2" style="font-weight: bold; background:#e1e1e1;text-align: center; font-size:15px">Past Organization</th>
            </tr>

            @foreach($member['json_data']['past_organization'] as $po)
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Position</td>
                <td style="border: 3px solid black;">{{$po->position}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Organization</td>
                <td style="border: 3px solid black;">{{$po->organization}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Adress</td>
                <td style="border: 3px solid black;">{{$po->address}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">From - To</td>
                <td style="border: 3px solid black;">{{$po->from}} - {{ $po->to}}</td>
            </tr>
            <tr>
                <th colspan="2" style="font-weight: bold; background:#e1e1e1;text-align: center; font-size:15px"></th>
            </tr>

            @endforeach

            {{-- expertise --}}
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Expertise</td>
                <td style="border: 3px solid black;">
                    @foreach($member['json_data']['expertise'] as $exp)
                    {{$exp->name}}<br/>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Google Scholar Link</td>
                <td style="border: 3px solid black;">{{$member['basic']->link_to_google_scholar}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">LinkedIn Profile Link</td>
                <td style="border: 3px solid black;">{{$member['basic']->linkedin_profile_link}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 3px solid black;   background:#efeaea">Bio</td>
                <td style="border: 3px solid black;"> {{$member['basic']->bio}}</td>
            </tr>
            
        </table>

    </body>
</html>
@php
    $basic = $data['basic'];
    $json = $data['json_data'];
    $member_full_name = $basic->full_name;
@endphp
<div>
            <table class="table table-striped table-bordered table-hover my-4 mr-2" style="background-color:#eefdf9; display:inline-table !important;">
                

                {{-- Educational Qualifications --}}
                <thead>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" class="text-center font-weight-bold text-white bg-success">{{ $member_full_name}}</th></tr>
                    <tr><th colspan="11" class="text-left font-weight-bold text-dark bg-bisque">Highest Degree Awarded So Far</th></tr>
                    <tr>
                        <th class="report-heading-second">S.N.</th>
                        <th class="report-heading-second th_large">Academic Level</th>
                        <th class="report-heading-second th_large">Others (If any)</th>
                        <th class="report-heading-second th_large">Subject/Research Title</th>
                        <th class="report-heading-second th_large">Name of University/Institution</th>
                        <th class="report-heading-second th_large">Address</th>
                        <th class="report-heading-second th_large">Year(A.D.)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $j = 1;
                        @endphp
                    @foreach($json['highest_degree'] as $degree)
                    <tr>
                        <td class="report-data text-center">{{  $j++ }}</td>
                        <td class="report-data-second">{{App\Models\Member::$degree_options[$degree->degree_name]}}</td>
                        <td class="report-data-second">{{$degree->others_degree}}</td>
                        <td class="report-data-second">{{$degree->subject_or_research_title}}</td>
                        <td class="report-data-second">{{$degree->university_or_institution}}</td>
                        <td class="report-data-second">{{$degree->country}}</td>
                        <td class="report-data-second">{{$degree->year}}</td>
                    </tr>
                    @endforeach
                </tbody>


                {{-- AIT Study --}}
                <thead>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" class="text-left font-weight-bold text-dark bg-bisque">Latest AIT Study Details</th></tr>
                    <tr>
                        <th class="report-heading-second">S.N.</th>
                        <th  class="report-heading-second th_large">Academic Level</th>
                        <th colspan="2"  class="report-heading-second th_large">Name of Degree</th>
                        <th  class="report-heading-second th_large">Name of School</th>
                        <th  class="report-heading-second th_large">Field of Study</th>
                        <th class="report-heading-second th_large">Graduation Year (A.D.)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $j = 1;
                        
                        @endphp
                    @foreach($json['ait_study_details'] as $degree)
                        @php
                        $school='';
                            if($degree->name_of_school == "4"){
                                $school = ' ('.$degree->name_of_other_school.')';
                            }
                        @endphp
                    <tr>
                        <td class="report-data text-center">{{  $j++ }}</td>
                        <td class="report-data-second">{{App\Models\Member::$degree_options[$degree->academic_level]}}</td>
                        <td colspan="2"  class="report-data-second">{{$degree->name_of_degree}}</td>
                        <td class="report-data-second">{{App\Models\Member::$school_options[$degree->name_of_school]}}{{$school}}</td>
                        <td  class="report-data-second">{{$degree->field_of_study}}</td>
                        <td class="report-data-second">{{$degree->graduation_year}}</td>
                    </tr>
                    @endforeach
                </tbody>

                {{-- current organization --}}
                <thead>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" class="text-left font-weight-bold text-dark bg-bisque">Current Organization</th></tr>
                    <tr>
                        <th class="report-heading-second">S.N.</th>
                        <th colspan="2" class="report-heading-second th_large">Position</th>
                        <th colspan="2" class="report-heading-second th_large">Organization</th>
                        <th colspan="2" class="report-heading-second th_large">Address</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $j = 1;
                        @endphp
                    @foreach($json['current_organization'] as $current)
                    <tr>
                        <td class="report-data text-center">{{  $j++ }}</td>
                        <td colspan="2" class="report-data-second">{{$current->position}}</td>
                        <td colspan="2" class="report-data-second">{{$current->organization}}</td>
                        <td colspan="2" class="report-data-second">{{$current->address}}</td>
                    </tr>
                    @endforeach
                </tbody>

                {{-- expertise --}}
                <thead>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" class="text-left font-weight-bold text-dark bg-bisque">Expertise</th></tr>
                    <tr>
                        <th class="report-heading-second">S.N.</th>
                        <th colspan="6" class="report-heading-second th_large">Expertise Area</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $j = 1;
                        @endphp
                    @foreach($json['expertise'] as $expertise)
                        @if($expertise->name != '')
                            <tr>
                                <td class="report-data text-center">{{  $j++ }}</td>
                                <td colspan="6" class="report-data-second">{{$expertise->name}}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>

                {{-- short bio --}}
                <thead>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" class="text-left font-weight-bold text-dark bg-bisque">Bio</th></tr>
                </thead>
                <tbody>
                    @php
                        $j = 1;
                        @endphp
                        @if($basic->bio != '')
                            <tr>
                                <td colspan="11" class="report-data-second">{{$basic->bio}}</td>
                            </tr>
                        @endif
                </tbody>
            </table>

    </div>

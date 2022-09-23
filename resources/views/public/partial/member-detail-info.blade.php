@php
    $basic = $data['basic'];
    $json = $data['json_data'];
    $member_full_name = $basic->first_name.' '.$basic->middle_name.' '.$basic->last_name;
@endphp
<div>
            <table class="table table-striped table-bordered table-hover my-4 mr-2" style="background-color:#eefdf9; display:inline-table !important;">
                {{-- current organization --}}
                <thead>
                    <tr><th colspan="11" class="text-center font-weight-bold text-white bg-success">{{ $member_full_name}}</th></tr>
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

                {{-- past organization --}}
                <thead>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" class="text-left font-weight-bold text-dark bg-bisque">Past Organization</th></tr>
                    <tr>
                        <th class="report-heading-second">S.N.</th>
                        <th colspan="3" class="report-heading-second th_large">Position</th>
                        <th colspan="3" class="report-heading-second th_large">Organization</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $j = 1;
                        @endphp
                    @foreach($json['past_organization'] as $past)
                        @if($past->position != '')
                            <tr>
                                <td class="report-data text-center">{{  $j++ }}</td>
                                <td colspan="3" class="report-data-second">{{$past->position}}</td>
                                <td colspan="3" class="report-data-second">{{$past->organization}}</td>
                            </tr>
                         @endif   
                    @endforeach
                </tbody>

                {{-- Educational Qualifications --}}
                <thead>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" class="text-left font-weight-bold text-dark bg-bisque">Educational Qualifications</th></tr>
                    <tr>
                        <th class="report-heading-second">S.N.</th>
                        <th class="report-heading-second th_large">Degree Name</th>
                        <th class="report-heading-second th_large">Others (If any)</th>
                        <th class="report-heading-second th_large">Subject/Research Title</th>
                        <th class="report-heading-second th_large">Name of University/Institution</th>
                        <th class="report-heading-second th_large">Address</th>
                        <th class="report-heading-second th_large">Year</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $j = 1;
                        @endphp
                    {{-- doctorate --}}
                    @foreach($json['doctorate_degree'] as $doctorate)
                    <tr>
                        <td class="report-data text-center">{{  $j++ }}</td>
                        <td class="report-data-second">{{$doctorate->degree_name}}</td>
                        <td class="report-data-second">{{$doctorate->degree_name}}</td>
                        <td class="report-data-second">{{$doctorate->subject_or_research_title}}</td>
                        <td class="report-data-second">{{$doctorate->university_or_institution}}</td>
                        <td class="report-data-second">{{$doctorate->country}}</td>
                        <td class="report-data-second">{{$doctorate->year}}</td>
                    </tr>
                    @endforeach

                    {{-- masters --}}
                    @foreach($json['masters_degree'] as $masters)
                    <tr>
                        <td class="report-data text-center">{{  $j++ }}</td>
                        <td class="report-data-second">{{$masters->degree_name}}</td>
                        <td class="report-data-second">{{$masters->degree_name}}</td>
                        <td class="report-data-second">{{$masters->subject_or_research_title}}</td>
                        <td class="report-data-second">{{$masters->university_or_institution}}</td>
                        <td class="report-data-second">{{$masters->country}}</td>
                        <td class="report-data-second">{{$masters->year}}</td>
                    </tr>
                    @endforeach

                    {{-- bachelors --}}
                    @foreach($json['bachelors_degree'] as $bachelors)
                    <tr>
                        <td class="report-data text-center">{{  $j++ }}</td>
                        <td class="report-data-second">{{$bachelors->degree_name}}</td>
                        <td class="report-data-second">{{$bachelors->degree_name}}</td>
                        <td class="report-data-second">{{$bachelors->subject_or_research_title}}</td>
                        <td class="report-data-second">{{$bachelors->university_or_institution}}</td>
                        <td class="report-data-second">{{$bachelors->country}}</td>
                        <td class="report-data-second">{{$bachelors->year}}</td>
                    </tr>
                    @endforeach
                </tbody>

                {{-- awards --}}
                <thead>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>

                    <tr><th colspan="11" class="text-left font-weight-bold text-dark bg-bisque">Awards</th></tr>
                    <tr>
                        <th class="report-heading-second">S.N.</th>
                        <th colspan="2" class="report-heading-second th_large">Award Name</th>
                        <th colspan="2" class="report-heading-second th_large">Awarded By</th>
                        <th colspan="2" class="report-heading-second th_large">Awarded Year</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $j = 1;
                        @endphp
                    @foreach($json['awards'] as $award)
                        @if($award->award_name != '')
                            <tr>
                                <td class="report-data text-center">{{  $j++ }}</td>
                                <td colspan="2" class="report-data-second">{{$award->award_name}}</td>
                                <td colspan="2" class="report-data-second">{{$award->awarded_by}}</td>
                                <td colspan="2" class="report-data-second">{{$award->awarded_year}}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>

                {{-- expertise --}}
                <thead>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" class="text-left font-weight-bold text-dark bg-bisque">Expertise</th></tr>
                    <tr>
                        <th class="report-heading-second">S.N.</th>
                        <th colspan="6" class="report-heading-second th_large">Name</th>
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
                {{-- affiliation --}}
                <thead>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" style="background-color: white !important;"></th></tr>
                    <tr><th colspan="11" class="text-left font-weight-bold text-dark bg-bisque">Affiliation</th></tr>
                    <tr>
                        <th class="report-heading-second">S.N.</th>
                        <th colspan="6" class="report-heading-second th_large">Name</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $j = 1;
                        @endphp
                    @foreach($json['affiliation'] as $affiliation)
                        @if($affiliation->name != '')
                            <tr>
                                <td class="report-data text-center">{{  $j++ }}</td>
                                <td colspan="6" class="report-data-second">{{$affiliation->name}}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

    </div>

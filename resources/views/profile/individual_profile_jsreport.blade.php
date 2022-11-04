<html>

<head>
  <style>
      @page{
        size: A4 portrait;
        margin:15px;
      }

      .header{
          color: black;
          opacity:.8
      }
      .name{
          /* margin-left:10px; */
          font-size:18px;
          font-weight: bold;
          color:rgb(29, 29, 170);
      }
      .table-data{
          margin-top: 20px;
          margin-left: 10px;
      }
      .row-title{
          padding:7px 0;
          font-weight:600;
          vertical-align:0%;
      }
      .inner-data{
          padding-bottom: 10px;
      }
      
      .inner-data li{
          padding-top: 5px;
      }
      .fa{
          font-size: 15px;
          color:black;
      }
      img{
          position: relative;
      }
      span.bracket-text{
          font-size: 15px !important;
          font-style: italic;
      }
      .subject{
          padding-top: 5px;
          margin-left: 30px;
      }
      .subject-title{
          font-weight: 600;
          font-size: 15px;
          line-height: 1.5rem;
          text-decoration: underline;
      }
      .subject-head{
          font-weight: 600;
          font-size: 15px;
          padding-top: 5px;
      }
      .subject-data{
        font-size: 15px;
        padding-top: 5px;
      }
      .link{
        color:blue;
        text-decoration: underline;
      }

      .education li {
          padding-bottom: 10px;
      }
      .contact div{
          padding-top: 10px;
      }
  
  </style>
</head>


<body class="main">
    @foreach($data as $member)
        <div class="header">
            Who is Who in AITAAN
        </div>
        <div class="hr-line">
            <hr/>
        </div>
        @php
            $dob = ($public_view == false) ? '; '.$member['basic']->dob_ad : ' ';
        @endphp
        <div class="profile">
            <span class="name"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;{{ $member['basic']->full_name}}
                ({{ $member['basic']->genderEntity->name_en}} 
                {{$member['basic']->district_id ?'; '.ucwords(strtolower($member['basic']->districtEntity->name_en)): ''}}
                {{$member['basic']->is_other_country==true && $member['basic']->countryEntity ? '; '.$member['basic']->countryEntity->name_en : '; Nepal' }})
            </span>
            <div class="table-data">
                <table width="100%">
                    <colgroup>
                        <col style="width: 30%;" />
                        <col style="width: 60%;" />
                        <col style="width: 10%;" />
                    </colgroup>
                        <tr>
                            <td class="row-title">Category :</td>
                            <td class="inner-data">
                                @foreach($member['json_data']['expertise'] as $expertise)
                                    @if($expertise->name !='')
                                        <li>{{ $expertise->name }}</li>
                                    @endif
                                @endforeach
                            </td>
                            <td class="row-data" style="text-align: right; padding-right:25px !important;">
                                <img style="border-radius:7px" src="{{$member['photo_encoded']}}" 
                                width="80" height="80" class="size-thumbnail p-1"></td>
                            </td>
                        </tr>
                
                        <tr>
                            <td class="row-title">Current Organization :</td>
                            <td class="row-data" colspan="2">&nbsp; {{ $member['json_data']['current_organization'][0]->position}}, 
                                {{$member['json_data']['current_organization'][0]->organization}},<br/>&nbsp;&nbsp;{{$member['json_data']['current_organization'][0]->address}}</td>
                        </tr>
                        <tr>
                            <td class="row-title">Past Experiences :</td>
                            <td class="inner-data" colspan="2">
                                @foreach($member['json_data']['past_organization'] as $dt)
                                    @if($dt->position !='')
                                    <li>{{ $dt->position }} <span class="bracket-text"> [ {{ $dt->organization}} ] ({{ 'From :'.$dt->from . ' - ' . 'To :'.$dt->to}})</span></li>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="row-title">Highest Degree Awarded :</td>
                            <td class="inner-data education" colspan="2">
                                @foreach($member['json_data']['highest_degree'] as $dt)
                                <li><span class="subject-title">Academic Level :</span> {{ App\Models\Member::$degree_options[$dt->degree_name] }} <br/>
                                    &ensp;&ensp;&ensp;<span class="subject-title">University/Institution :</span> {{ $dt->university_or_institution}}<br/>
                                    &ensp;&ensp;&ensp;<span class="subject-title">Country, Year :</span> {{$dt->country}}, {{$dt->year}}<br>
                                    &ensp;&ensp;&ensp;<span class="subject-title">Subject / Research Title :</span> {{$dt->subject_or_research_title}}</div></li>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="row-title">Lastest AIT study details :</td>
                            <td class="inner-data" colspan="2">
                                @foreach($member['json_data']['ait_study_details'] as $dt)
                                @php
                                $school='';
                                    if($dt->name_of_school == "4"){
                                        $school = ' ('.$dt->name_of_other_school.')';
                                    }
                                @endphp
                                <li><span class="subject-title">Academic Level :</span> {{ App\Models\Member::$degree_options[$dt->academic_level] }}<br/>
                                    &ensp;&ensp;&ensp;<span class="subject-title">Degree :</span> {{$dt->name_of_degree}} <br> 
                                    &ensp;&ensp;&ensp;<span class="subject-title">School , Year :</span> {{ App\Models\Member::$school_options[$dt->name_of_school]}}{{$school}}, {{$dt->graduation_year}}</span><br>
                                    &ensp;&ensp;&ensp;<span class="subject-title">Field of Study / Division / Department / Program :</span> {{$dt->field_of_study}}</div></li>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="row-title">Expertise :</td>
                            <td class="inner-data" colspan="2">
                                @foreach($member['json_data']['expertise'] as $expertise)
                                    @if($expertise->name !='')
                                        <li>{{ $expertise->name }}</li>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                       
                        <tr>
                            <td class="row-title">Correspondence :</td>
                            <td class="row-data contact" colspan="2">
                                <div>
                                    <span class="subject-head">Mailing Address : </span><span class="subject-data">{{$member['basic']->mailing_address}}</span>
                                </div>
                                @if(!$public_view)
                                    <div>                                
                                        <span class="subject-head">Phone/Cell Number : </span><span class="subject-data">{{$member['basic']->phone}}</span>
                                    </div>
                                @endif
                                @if(!$public_view)
                                    <div>
                                    <span class="subject-head"> E-mail : </span><span class="subject-data">{{$member['basic']->email}}</span>
                                    </div>
                                 @endif
                                <div>
                                <span class="subject-head"> Google Scholar Link : </span><span class="subject-data link"><a target="_blank" href="{{$member['basic']->link_to_google_scholar}}">{{$member['basic']->link_to_google_scholar}}</a></span>
                                </div>
                                <div>
                                <span class="subject-head"> Linkedin Link : </span><span class="subject-data link"><a target="_blank" href="{{$member['basic']->linkedin_profile_link}}">{{$member['basic']->linkedin_profile_link}}</a></span>
                                </div>
                            </td>
                        </tr>
                </table>
            </div>
        </div>
        @if(count($data)>1)
        <p style="page-break-after: always"></p>
        @endif
    @endforeach
</body>

</html>
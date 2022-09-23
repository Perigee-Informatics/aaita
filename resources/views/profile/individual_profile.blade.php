<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style>
      @page{
        size: A4 portrait;
        margin-top: 30px;
        margin-left: 30px;
        margin-right: 30px;
        margin-bottom: 30px;
      }

      .header{
          color: black;
          opacity:.8
      }
      .name{
          margin-left:20px;
          font-size:25px;
          font-weight: bold;
          color:rgb(29, 29, 170);
      }
      .table-data{
          margin-top: 20px;
          margin-left: 20px;
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
          font-size: 25px !important;
          font-style: italic;
      }
      .subject{
          padding-top: 5px;
          margin-left: 30px;
      }
      .subject-title{
          font-weight: 600;
          font-size: 25px;
          padding-top: 5px;
          text-decoration: underline;
      }
      .subject-head{
          font-weight: 600;
          font-size: 25px;
          padding-top: 5px;
      }
      .subject-data{
        font-size: 20px;
        padding-top: 5px;
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
            Who is Who in Science, Technology and Innovation of Nepal
        </div>
        <div class="hr-line">
            <hr/>
        </div>
        @php
            $dob = ($public_view == false) ? '; '.$member['basic']->dob_ad : ' ';
        @endphp
        <div class="profile">
            <span class="name"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;{{ $member['basic']->first_name .' '.$member['basic']->middle_name.' '. $member['basic']->last_name}}
                ({{ $member['basic']->genderEntity->name_en.$dob}} 
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
                            <td class="row-title">Category:</td>
                            <td class="inner-data">
                                @foreach($member['json_data']['expertise'] as $expertise)
                                    @if($expertise->name !='')
                                        <li>{{ $expertise->name }}</li>
                                    @endif
                                @endforeach
                            </td>
                            <td class="row-data" style="text-align: right; padding-right:25px !important;">
                                <img style="border-radius:7px" src="{{$member['photo_encoded']}}" 
                                width="100" height="100" class="size-thumbnail p-1"></td>
                            </td>
                        </tr>
                
                        <tr>
                            <td class="row-title">Current Affiliation:</td>
                            <td class="row-data" colspan="2">{{ $member['json_data']['current_organization'][0]->position}}, 
                                {{$member['json_data']['current_organization'][0]->organization}}, {{$member['json_data']['current_organization'][0]->address}}</td>
                        </tr>
                        <tr>
                            <td class="row-title">Past Experiences:</td>
                            <td class="inner-data" colspan="2">
                                @foreach($member['json_data']['past_organization'] as $dt)
                                    @if($dt->position !='')
                                    <li>{{ $dt->position }} <span class="bracket-text"> ( {{ $dt->organization}} )</span></li>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="row-title">Education:</td>
                            <td class="inner-data education" colspan="2">
                                @foreach($member['json_data']['doctorate_degree'] as $dt)
                                <li>{{ $dt->degree_name }} <span class="bracket-text"> - {{ $dt->university_or_institution}}, {{$dt->country}}, {{$dt->year}}</span><br>
                                <div class="subject"><span class="subject-title">Subject / Research Title</span> : <span class="subject-data">{{$dt->subject_or_research_title}}</span></div></li>
                                @endforeach

                                @foreach($member['json_data']['masters_degree'] as $dt)
                                <li>{{ ($dt->others_degree)? $dt->others_degree: $dt->degree_name }} <span class="bracket-text"> - {{ $dt->university_or_institution}}, {{$dt->country}}, {{$dt->year}}</span><br>
                                <div class="subject"><span class="subject-title">Subject / Research Title</span> : <span class="subject-data">{{$dt->subject_or_research_title}}</span></div></li>
                                @endforeach

                                @foreach($member['json_data']['bachelors_degree'] as $dt)
                                <li>{{ ($dt->others_degree) ? $dt->others_degree: $dt->degree_name }} <span class="bracket-text"> - {{ $dt->university_or_institution}}, {{$dt->country}}, {{$dt->year}}</span><br>
                                <div class="subject"><span class="subject-title">Subject / Research Title</span> : <span class="subject-data">{{$dt->subject_or_research_title}}</span></div></li>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="row-title">Awards:</td>
                            <td class="inner-data" colspan="2">
                                @foreach($member['json_data']['awards'] as $award)
                                    @if($award->award_name !='')
                                        <li>{{ $award->award_name }} <span class="bracket-text"> ( {{ $award->awarded_by}}, {{ $award->awarded_year}} )</span></li>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="row-title">Expertise:</td>
                            <td class="inner-data" colspan="2">
                                @foreach($member['json_data']['expertise'] as $expertise)
                                    @if($expertise->name !='')
                                        <li>{{ $expertise->name }}</li>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="row-title">Professional Affiliation:</td>
                            <td class="inner-data" colspan="2">
                                @foreach($member['json_data']['affiliation'] as $affiliation)
                                    @if($affiliation->name !='')
                                        <li>{{ $affiliation->name }}</li>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="row-title">Correspondence:</td>
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
                                <span class="subject-head"> Link to Google Scholar : </span><span class="subject-data">{{$member['basic']->link_to_google_scholar}}</span>
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
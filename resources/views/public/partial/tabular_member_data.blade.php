    <table id="members_data_table" class="table table-bordered table-sm table-striped mr-2 pr-2 mt-3" style="background-color:#f8f9fa;">
        <thead>
            <tr>
                <th class="report-heading">S.N.</th>
                <th class="report-heading th_large">Full Name</th>
                <th class="report-heading th_large">Gender</th>
                {{-- <th class="report-heading th_large">Channel</th> --}}
                {{-- <th class="report-heading th_large">Membership Type</th> --}}
                <th class="report-heading th_large">Country</th>
                <th class="report-heading th_large">Province</th>
                <th class="report-heading th_large">District</th>
                {{-- <th class="report-heading th_large">Mailing Address</th> --}}
                {{-- <th class="report-heading th_large">E-mail</th> --}}
                <th class="report-heading th_large">Link to Google Schloar</th>
                <th class="report-heading th_large">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($data as $key=>$member)
                @php
                    $rowId = 'member-'.$key;
                    $basic = $member['basic'];
                    $json = $member['json_data'];
                    $member_full_name = $basic->full_name;
                @endphp

                <tr>
                    <td class="report-data text-center">{{$loop->iteration}}</td>
                    <td class="report-data">{{$member_full_name}}</td>
                    <td class="report-data">{{$basic->genderEntity->name_en}}</td>
                    {{-- <td class="report-data">{{$channel}}</td> --}}
                    {{-- <td class="report-data">{{$m_type}}</td> --}}
                    <td class="report-data">{{$basic->countryEntity ? $basic->countryEntity->name_en : 'Nepal'}}</td>
                    <td class="report-data">{{$basic->provinceEntity->name_en}}</td>
                    <td class="report-data">{{$basic->districtEntity->name_en}}</td>
                    {{-- <td class="report-data">{{$basic->mailing_address}}</td> --}}
                    {{-- <td class="report-data">{{$basic->email}}</td> --}}
                    <td class="report-data">{{$basic->link_to_google_scholar}}</td>
                    <td class="report-data text-center">
                        <a class="fancybox btn btn-warning p-1 mr-2" data-type="ajax" data-src="{{'/public/member/'.$key.'/send-email-view'}} " title='Send Mail to Expert'>
                            <i class="la la-envelope text-black font-weight-bold"></i>
                        </a>
                        <a class="fancybox btn btn-success p-1 mr-2" data-type="ajax" data-src="{{'/public/member/'.$key.'/view-detailed-info'}} " title='View Detail'>
                            <i class="la la-eye text-white font-weight-bold"></i>
                        </a>
	                    <a target="_blank" href="{{ url('/public/member/'.$key.'/print-profile') }}" class="btn btn-primary print-btn p-1" data-style="zoom-in">
                            <i class="la la-print font-weight-bold"></i></a>
                    </td>
                </tr>
            
            @endforeach    
        </tbody>
    </table>
    <div class="row mt-3">
        <div class="col">
            @include('public.partial.pagination', ['paginator' => $data])
        </div>
    </div>



<style>
    .report-heading {
        font-size: 14px;
    }

    .bg-bisque{
        background-color: bisque !important;
        text-decoration: underline;
        text-decoration-style: double;
        text-decoration-color: blue;
        text-align: center !important;
        font-size: 16px !important;
    }
    .report-heading-second{
        font-size:13px;
        padding:0px;
        color:black !important;
        background-color:lightgray !important;
    }

    .report-data {
        font-size: 14px;
        font-weight: 600;
        color: black;
        max-width:150px !important;

        /* font-family: 'Kalimati'; */
    }
    .report-data-second{
        text-align: left;
        padding-right:20px !important;
    }

    tr>th {
        border-bottom: 1px solid white !important;
        border-right: 1px solid white !important;
        background-color: #3B72A0 !important;
        color: white;
    }
    tr>td {
        border-bottom: 1px solid grey !important;
        border-right: 1px solid grey !important;
    }
    tr>td:hover{
        cursor: pointer;
    }

    .th_large {
        /* min-width: 100px !important; */
        /* max-width:100px !important; */
    }
    .th_small{
        max-width: 75px;
    }
    .num-data{
        text-align: right;
    }
    .th_footer{
        text-align: right;
        font-size:16px;
    }
    .table th{
        padding:.5rem .75rem !important;
    }
</style>


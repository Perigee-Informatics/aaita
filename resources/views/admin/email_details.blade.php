@extends(backpack_view('layouts.top_left'))

@section('content')

<style src="{{asset('packages/dataTables-custom/css/dataTables.bootstrap4.min.css')}}"></style>
<style src="{{asset('public/packages/dataTables-custom/css/select.dataTables.min.css')}}"></style>
<style src="{{asset('packages/jquery-ui/css/jquery-ui.css')}}"></style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

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


<div class="card">
    <div class="card-header p-1 d-inline-block" style="background-color: rgb(43, 208, 223)">
        <span class="font-weight-bold"><i class="la la-envelope" aria-hidden="true"></i>&nbsp; Emails List</span>
    </div>

    <div class="card-body p-1">
            <table id="email_data_table" class="table table-bordered table-sm table-striped mr-2 pr-2 mt-3" width="100%" style="background-color:#f8f9fa;">
                <thead>
                    <tr>
                        <th class="report-heading">S.N.</th>
                        <th class="report-heading th_large">Reporting Person</th>
                        <th class="report-heading th_large">Contact</th>
                        <th class="report-heading th_large">Email</th>
                        <th class="report-heading th_large">Subject</th>
                        <th class="report-heading th_large">Message</th>
                        <th class="report-heading th_large">Sent To</th>
                    </tr>
                </thead>
        
                <tbody>
                    @foreach($datas as $data)
                        @php
                        $member = App\Models\Member::find($data->sent_to_member_id);
                        $member_full_name = $member->first_name.' '.$member->middle_name.' '.$member->last_name;
        
                        @endphp
                        <tr>
                            <td class="report-data text-center">{{$loop->iteration}}</td>
                            <td class="report-data">{{$data->reporting_person}}</td>
                            <td class="report-data">{{$data->mobile_num}}</td>
                            <td class="report-data">{{$data->email}}</td>
                            <td class="report-data">{{$data->subject}}</td>
                            <td class="report-data">{{$data->message}}</td>
                            <td class="report-data">{{$member_full_name}}</td>
                        </tr>
                    @endforeach    
                </tbody>
            </table>
    </div>

</div>


@section('after_scripts')
<script src="{{asset('packages/dataTables-custom/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('packages/dataTables-custom/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('packages/dataTables-custom/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('packages/jquery-ui/js/jquery-ui.js')}}"></script>

<script>
        $('#email_data_table').DataTable({
            searching: true,
            paging: true,
            ordering: true,
            select: false,
            bInfo: true,
            lengthChange: true
        });
</script>
@endsection
@endsection
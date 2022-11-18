@extends(backpack_view('layouts.plain'))

        <!-- leaflet -->
        <link rel="stylesheet" href="{{asset('homepage/css/leaflet.css')}}"/>

        <!-- custom css -->
        <link rel="stylesheet" href="{{asset('homepage/css/map.css')}}" />
        <link rel="stylesheet" href="{{asset('homepage/css/custom.css')}}" />
       
        <!-- custom count css -->
        <link rel="stylesheet" href="{{ asset('homepage/css/markerCluster.css') }}" />
        <!-- chartjs -->
        <link rel="stylesheet" href="{{asset('homepage/css/chart.min.css')}}" />
        



@section('content')
    <div class="row card" style="width: 100%" id="main">

        {{-- <div class="card-header">
            <div class="form-row">
                <div class="col p-1 ml-3">
                    <div class="nav nav-pills">
                        <a class="p-1 pl-3 pr-3 tab-btn nav-link bg-primary text-white" 
                        id="btn-graphical" href="javascript:;"><i class="fa fa-sitemap"></i> Graphical</a> 

                        <a class="p-1 pl-3 tab-btn pr-3 nav-link bg-primary text-white" 
                        id="btn-tabular" href="javascript:;"><i class="fa fa-table"></i> Tabular</a> 
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="col p-0 border rounded p-2" id="body-content"></div> --}}
        {{-- @if(Str::contains(url()->current(),'public/list-members')) --}}
            @include('public.partial.tabular_index')
        {{-- @else
            @include('public.partial.graphical')
        @endif --}}
    </div>

@endsection

    @push('after_scripts')
        <script>
            $(document).ready(function(){


                  $('body').on('keyup', function(e) {
                    let keyPressed = e.which ? e.which : e.keyCode;

                    //dissmiss modal on escape key
                    if(keyPressed==27){
                        closeNav();
                    }
                });

            });
        </script>

        {{-- for data filtering on chart data click --}}
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "200px";
            }
            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }

            function filterData(item)
            {
                
                let type = $(item).data('type');
                let pid = $(item).data('pid');
                let did = $(item).data('did');
                let gid = $(item).data('gender_id');

                localStorage.setItem('type',type);
                if(pid != '' && pid != 'undefined'){
                    localStorage.setItem('province_id',pid);
                }
                if(did != '' && did != 'undefined'){
                    localStorage.setItem('district_id',did);
                }
                if(gid != '' && gid != 'undefined'){
                    localStorage.setItem('gender_id',gid);
                }

                if(type == 'age_group'){

                    let set_pid = $(item).data('set_pid');
                    let key = $(item).data('key');

                    if(set_pid != '' && set_pid != 'undefined'){
                        localStorage.setItem('province_id',set_pid);
                    }
                    if(key != '' && key != 'undefined'){
                        localStorage.setItem('age_group',key);
                    }
                }

                window.location.href= '/public/list-members';

            }

        </script>

    @endpush

   

  


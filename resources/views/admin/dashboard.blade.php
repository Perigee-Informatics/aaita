@extends(backpack_view('layouts.top_left'))

    @section('content')

        <!-- leaflet -->
        <link rel="stylesheet" href="{{asset('homepage/css/leaflet.css')}}"/>

        <!-- custom css -->
        <link rel="stylesheet" href="{{asset('homepage/css/map.css')}}" />

        <!-- custom count css -->
        <link rel="stylesheet" href="{{ asset('homepage/css/markerCluster.css') }}" />
        <!-- chartjs -->
        <link rel="stylesheet" href="{{asset('homepage/css/chart.min.css')}}" />
        <link rel="stylesheet" href="{{asset('homepage/css/custom.css')}}">


        <script src="{{asset('homepage/js/leaflet.js')}}"></script>


            <!-- PRE LOADER -->
            <div class="preloader">
                <div class="spinner">
                    <span class="sk-inner-circle"></span>
                </div>
            </div>
            <div class="spinner-border" id="custom_spinner" role="status">
                <span class="sr-only">Loading...</span>
            </div>

            <div class="card mb-0" style="background-color:#d9d9d9;">
                <div class="card-header bg-primary p-0">
                    <div class="form-row mb-3">
                        <div class="col-sm-12 col-md-4"><i class="la la-map-marked-alt ml-2"> WHO is WHO Scientist Distribution</i></div>
                        <div class="col-sm-12 col-md-8">
                            <nav aria-label="breadcrumb" class="map-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><span id="country_button"></span></li>
                                        
                                    <i class="la la-angle-right" id="province-angle-right"></i>
                                    <li class="breadcrumb-item"><span id="province_button"></span></li>
                                    
                                    <i class="la la-angle-right" id="district-angle-right"></i>
                                    <li class="breadcrumb-item"><span id="district_button"></span></li>
                                    
                                    <i class="la la-angle-right" id="locallevel-angle-right"></i>
                                    <li class="breadcrumb-item"><span id="locallevel_button"></span></li>
                    
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>


            <!-- HOME -->
            <section id="home" class="parallax-section">
                <div class="overlay">
                <img src={{asset("img/banner.jpg")}} width="100%" height="100%" style="opacity: 0.1"/></div>
                <div class="container map-container">
                    <div class="row">
                        <div id='map'></div>
                    </div>
                </div>
            </section>

             <!-- Fed Area -->
            <section id="fed_area" class="parallax-section">
                <div class="container bootstrap snippet" id="fed_area_container">
                    <div class="form-row">
                        <div class="col">
                            <div class="box">
                                <div class="box-icon">
                                    <img src={{asset("homepage/img/district.png")}} height="50" width="50" />
                                    <span class="circle-tile-number" id="total_province_count">-</span>
                                </div>
                                <div class="circle-tile-description"> Provinces</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="box">
                                <div class="box-icon">
                                    <img src={{asset("homepage/img/district.png")}} height="50" width="50" />
                                    <span class="circle-tile-number" id="total_district_count">-</span>
                                </div>
                                <div class="circle-tile-description"> Districts</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="box ">
                                <div class="box-icon">
                                    <img src={{asset("homepage/img/Municipality.png")}} height="50" width="50" />
                                    <span class="circle-tile-number" id="metro_count">-</span>
                                </div>
                                <div class="circle-tile-description"> Metropolitian City</div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="box">
                                <div class="box-icon">
                                    <img src={{asset("homepage/img/building.png")}} height="50" width="50" />
                                    <span class="circle-tile-number" id="sub_metro_count">-</span>
                                </div>
                                <div class="circle-tile-description"> Sub-Metropolitian City</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col">
                            <div class="box">
                                <div class="box-icon">
                                    <img src={{asset("homepage/img/Village.png")}} height="50" width="50" />
                                    <span class="circle-tile-number" id="mun_count">-</span>
                                </div>
                                <div class="circle-tile-description"> Municipality</div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="box">
                                <div class="box-icon">
                                    <img src={{asset("homepage/img/house.png")}} height="50" width="50" />
                                    <span class="circle-tile-number" id="rural_mun_count">-</span>
                                </div>
                                <div class="circle-tile-description"> Rural Municipality</div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="box">
                                <div class="box-icon">
                                    <img src={{asset("homepage/img/all.png")}} height="50" width="50" />
                                    <span class="circle-tile-number" id="total_local_level_count">-</span>
                                </div>
                                <div class="circle-tile-description"> Total Rural/Municipality</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- Gender wise Distribution -->
            <section id="gender_card" class="parallax-section">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-5">
                            <div class="brand-card">
                                <div class="brand-card-header bg-stack-overflow">
                                    <h6 style="color: white;" id="gender_card_title"></h6>
                                </div>
                                <div class="brand-card-body">
                                    <div style="max-width:60px;">
                                        <div class="text-header">S.N.</div>
                                        <div id="gender_row_number"></div>
                                    </div>
                                    <div style="min-width:150px;">
                                        <div class="text-header" id="table_level_title">-</div>
                                        <div id="gender_name"></div>
                                    </div>
                                    <div>
                                        <div class="text-header">Male</div>
                                        <div id="gender_male_count"></div>
                                    </div>
                                    <div>
                                        <div class="text-header">Female</div>
                                        <div id="gender_female_count"></div>
                                    </div>
                                    <div>
                                        <div class="text-header">Total</div>
                                        <div id="gender_total_count"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-7">
                            <div class="card text-center font-weight-bold mb-3" style="border-top:5px solid red; border-bottom:5px solid lightgray; border-radius:20px">
                                <canvas id="gender_distribution_chart" style="background-color:white; border-radius:20px;"></canvas>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </section>

              <!-- age wise card -->
              <section id="age_card" class="parallax-section">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-5">
                            <div class="brand-card">
                                <div class="brand-card-header bg-stack-overflow">
                                    <h6 style="color: white;" id="age_card_title"></h6>
                                </div>
                                <div class="brand-card-body">
                                    <div style="max-width:60px;">
                                        <div class="text-header">S.N.</div>
                                        <div id="age_row_number"></div>
                                    </div>
                                    <div>
                                        <div class="text-header">Age Group</div>
                                        <div id="age_name"></div>
                                    </div>
                                    <div>
                                        <div class="text-header">Members Count</div>
                                        <div id="age_count"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-7">
                            <div class="card text-center font-weight-bold mb-3" style="border-top:5px solid green; border-bottom:5px solid lightgray; border-radius:20px">
                                <canvas id="age_distribution_chart"  style="background-color:white; border-radius:20px;"></canvas>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </section> 
    @endsection

    @push('after_scripts')

        <!-- SCRIPTS -->
        <script src="{{asset('homepage/js/jquery.js')}}"></script>
        <script src="{{asset('packages/select2/dist/js/select2.full.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('homepage/js/jquery.parallax.js')}}"></script>
        <script src="{{asset('homepage/js/owl.carousel.min.js')}}"></script>
        <script src="{{asset('homepage/js/custom.js')}}"></script>

        <script src="{{asset('homepage/js/moment.min.js')}}"></script>
        <script src="{{asset('homepage/js/chart.min.js')}}"></script>

        <script src="{{ asset('homepage/js/leaflet.markercluster-src.js') }}"></script>
        <script src="{{asset('homepage/js/currencyFormatter.min.js')}}"></script>
        <script src="{{asset('homepage/js/plotmap.js')}}"></script>

    @endpush

   

  


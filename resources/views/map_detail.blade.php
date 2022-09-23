@extends(backpack_view('blank'))

<link rel="stylesheet" href="{{ asset('gismap/css/gismap.css') }}" />
<link rel="stylesheet" href="{{ asset('gismap/css/mapview.css') }}" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{asset('gismap/js/accordion.js') }}"></script>
<script src="{{asset('js/dependentdropdown.js') }}"></script>


@section('header')
	<section class="container-fluid">
	    <h3 class="text-primary text-center">
            <span class="text"><b>परियोजनाहरुको भौगोलिक अवस्थिति</b></span>
	    </h3>
	</section>
@endsection

@section('content') 
<div class="card">
@if(backpack_user()->isClientUser() === false)
		<div class="card">
			<div class="card-header bg-primary p-1"><i class="la la-search"aria-hidden="true"></i>Search</div>
			<div class="card-body p-0">
			  	<div class="form-row p-2">
					<div class="col-md-3">
						<select class="form-control select2" style="width: 100%;" name="fiscal_year_id" id="fiscal_year_id" onchange="getGisData()">
							<option selected disabled>--आर्थिक वर्ष छान्नुहोस्--</option>
							@foreach($project_fiscal_year as $fiscal_year)
							<option class="form-control" value="{{ $fiscal_year->id }}">{{ $fiscal_year->code }}</option>
							@endforeach
						</select>
					</div>
					<div class="col">
						<select class="form-control select2" name="province" id="province" style="width: 100%;" onchange="getGisData()">
							<option selected disabled style="font-weight:bold;">--प्रदेश छान्नुहोस्--</option>
							@foreach($project_province as $y)
							<option class="form-control nepali_td" value="{{ $y->id }}">{{ $y->code }}-{{ $y->name_lc }}</option>
							@endforeach
						</select>
					</div>
					<div class="col">
						<select class="form-control select2" style="width: 100%;" name="district" id="district" onchange="getGisData()">
							<option disabled style="font-weight:bold;">--पहिला प्रदेश छान्नुहोस्--</option>
						</select>
					</div>
					<div class="col">
						<select class="form-control select2" style="width: 100%;" name="local_level" id="local_level" onchange="getGisData()">
							<option disabled style="font-weight:bold;">--पहिला जिल्ला छान्नुहोस्--</option>
						</select>
					</div>
				</div>
				<div class="form-row p-2">
					<div class="col">
						<select class="form-control select2" style="width: 100%;" name="category_id" id="category_id" onchange="getGisData()">
							<option selected disabled>--आयोजना प्रकार छान्नुहोस्--</option>
							@foreach($project_category as $category)
							<option class="form-control nepali_td" value="{{ $category->id }}">{{ $category->code }}-{{ $category->name_lc }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-3">
						<select class="form-control select2" style="width: 100%;" name="sub_category_id" id="sub_category_id" onchange="getGisData()">
							<option disabled style="font-weight:bold;">--पहिला आयोजना प्रकार छान्नुहोस्--</option>
						</select>
					</div>
					<div class="col-md-3">
						<select class="form-control select2" style="width: 100%;" name="status" id="status" onchange="getGisData()">
							<option selected disabled>-- आयोजना स्थिति छान्नुहोस्--</option>
							@foreach($project_status as $status)
							<option class="form-control" value="{{ $status->id }}">{{ $status->name_lc }}</option>
							@endforeach
						</select>
					</div>
					
					<div class="col-md-3">
						<a class="btn btn-warning float-right" href="{{route('gisdata')}}" type="reset"><i class="fa fa-refresh"></i>Reset</a>
					</div>
				</div>
			</div>

		</div>
		@endif
		
		<div class="row">
			<div class="col">
				<div class="card h-100">
					<div id="gis_map_data"></div>
				</div>
			</div>
		</div>
	</div>
@endsection


@push('after_scripts')
<script>
$(document).ready(function () {
    getGisData();
    $('#search_button').click(function(){
        getGisData();
    });
});

function getGisData(){
        let province = $('#province').val();
        let district = $('#district').val();
        let local_level = $('#local_level').val();
        let category_id = $('#category_id').val();
        let sub_category_id = $('#sub_category_id').val();
        let status = $('#status').val();
        let fiscal_year = $('#fiscal_year_id').val();
		$('#gis_map_data').html('<div class="text-center"><img src="/css/images/loading.gif"/></div>');

        $.ajax({
            type: "GET",
            url: "/admin/gisfilterdata",
            data: {province: province, district: district,local_level: local_level, category_id: category_id,
			sub_category_id: sub_category_id, status: status,fiscal_year: fiscal_year},
            success: function(response){
                $('#gis_map_data').html(response);
            }
        });
 }

</script>
@endpush


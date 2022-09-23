<div class="row">
	<div class="col-md-8">
		<div class="card" style="border-radius:10px; border-top:5px solid red; background-size:cover;">
			<div class="box">
				<div class="box-body m-2">
					<div class="tab-content" style="border-radius:10px;">
						<div class=" active tab-pane" id="activity" style="margin-top:2%;">
							<link rel="stylesheet" href="{{ asset('gismap/css/leaflet.css') }}" />
							<script src="{{ asset('/gismap/js/leaflet-src.js') }}"></script>
							<link rel="stylesheet" href="{{ asset('/gismap/css/MarkerCluster.css') }}" />
							<link rel="stylesheet" href="{{ asset('/gismap/css/MarkerCluster.Default.css') }}" />
							<script src="{{ asset('/gismap/js/leaflet.markercluster-src.js') }}"></script>
							<div class="map-body">
								<div id="map"></div>
								@php
									$client_lat = Session::get('client_lat');
									$client_long = Session::get('client_long');
									$client_lat = isset($client_lat) ? json_encode($client_lat) : json_encode(null);
									$client_long = isset($client_lat) ? json_encode($client_long) : json_encode(null);
								@endphp
								<link rel="stylesheet" href="{{ asset('gismap/css/Control.FullScreen.css') }}" />
								<script src="{{ asset('/gismap/js/Control.FullScreen.js') }}"></script>
								<script>
									var json = <?php echo $markers; ?>;
									var client_lat = <?php echo $client_lat; ?>;
									var client_long = <?php echo $client_long; ?>;
								</script>
								<script src="{{ asset('gismap/js/leafletopenstreet.js') }}"></script>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card" style="border-radius:10px; border-top:5px solid blue; background-size:cover;">
			<div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title text-center" style="text-decoration:underline blue">Project Summary</h4>
                    <div class="box-body p-2">
                            @php
                            $sum=0;
                            $project_sum=0;
                          @endphp

						  <table>
							<tbody>
							@foreach($category_count as $cate)
							<tr>
								<td style="padding:2;"><img class="open-street" src='/gismap/icons/{{$cate->code}}.png' width="20px">&nbsp;&nbsp;&nbsp;{!! $cate->name_lc !!}</td>
								<td style="padding:2; text-align:right"><span class="font-weight-bold text-white badge bg-red" style="font-size:14px;">@englishToNepaliDigits($cate->count)</span></td>
								@php
								$totalcategory=$cate->count;
								$sum+=$totalcategory;
								$totalprojectcost=$cate->totalcost;
								$project_sum+=$totalprojectcost;
								@endphp
							</tr>
                        @endforeach
							<tr>
								<td><span style="color:blue"><b> <i class="la la-asterisk"></i> जम्मा परियोजनाहरु</b></span></td>
								<td style="text-align:right"><span class="text-white badge bg-green" style="font-size:14px;">@englishToNepali($sum)</span></td>
							</tr>
							<tr>
								<td><span style="color:blue"><i class="la la-asterisk"></i> जम्मा लागत </span></td>
								<td style="text-align:right"><span class="text-white badge bg-green" style="font-size:14px;">@englishToNepali($project_sum)</span></td>
							</tr>
							</tbody>
						  </table>
                    </div>
                </div>
            </div>
		</div>

		{{--
			<div class="card" style="border-radius:10px; border-top:5px solid green; background-size:cover;">
			<div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title text-center" style="text-decoration:underline red">Project By Status</h4>
                    <div class="box-body p-2">
						
                    </div>
                </div>
            </div>
		</div>
		--}}
	</div>
</div>





@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.preview') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid d-print-none">
    	<a href="javascript: window.print();" class="btn float-right"><i class="la la-print"></i></a>
		<h2>
	        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
	        <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}.</small>
	        @if ($crud->hasAccess('list'))
	          <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
	        @endif
	    </h2>
    </section>
@endsection

@section('content')
<div class="row">
	<div class="{{ $crud->getShowContentClass() }}">

	<!-- Default box -->
	  <div class="">
	  	@if ($crud->model->translationEnabled())
			<div class="row">
				<div class="col-md-12 mb-2">
					<!-- Change translation button group -->
					<div class="btn-group float-right">
					<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('locale')?request()->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						@foreach ($crud->model->getAvailableLocales() as $key => $locale)
							<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?locale={{ $key }}">{{ $locale }}</a>
						@endforeach
					</ul>
					</div>
				</div>
			</div>
	    @endif
	    <div class="card no-padding no-border">
			<table class="table table-striped mb-0">
		        <tbody>
				
		        @foreach ($crud->columns() as $column)
		            <tr>
		                <td style="width:350px;">
		                    <strong>{!! $column['label'] !!}:</strong>
		                </td>
                        <td>
							@if (!isset($column['type']))
		                      @include('crud::columns.text')
		                    @else
		                      @if(view()->exists('vendor.backpack.crud.columns.'.$column['type']))
		                        @include('vendor.backpack.crud.columns.'.$column['type'])
		                      @else
		                        @if(view()->exists('crud::columns.'.$column['type']))
		                          @include('crud::columns.'.$column['type'])
		                        @else
		                          @include('crud::columns.text')
		                        @endif
		                      @endif
		                    @endif
                        </td>
		            </tr>
		        @endforeach
				@if ($crud->buttons()->where('stack', 'line')->count())
					<tr>
						<td><strong>{{ trans('backpack::crud.actions') }}</strong></td>
						<td>
							@include('crud::inc.button_stack', ['stack' => 'line'])
						</td>
					</tr>
				@endif
		        </tbody>
			</table>

			<hr>
			<div class="terms p-2 pl-4">
				<span class="font-weight-bold" style="color:red;">*** Note : </span>
				<span style="color:red; font-weight:bold; font-size:13px;">By clicking “I Agree” below you are indicating that the information you provided above is correct, and agree for the consent to publish this information into AAITAN (WHO is WHO) souvenir.</span>
				<div class="checkbox" style="color: blue;">
					  <input type="checkbox" id="terms_check_box" onclick="enableDisableButton()">
						<label class="form-check-label font-weight-normal" for="terms_check_box"><b>&nbsp; I Agree. </b></label>
				</div>
			</div>

			@if(isset($set_confirm_submit) && $set_confirm_submit)
			<center><div class="py-3">
				<a class="btn btn-success text-white" role="button" id="submit_confirm_button" onclick="submitConfirm()">
					<span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
					<span >Submit</span>
				</a>
			</div>
		</center>
	
			@endif
	    </div><!-- /.box-body -->
	  </div><!-- /.box -->

	</div>
</div>
@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css').'?v='.config('backpack.base.cachebusting_string') }}">
	<link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/show.css').'?v='.config('backpack.base.cachebusting_string') }}">
@endsection

@section('after_scripts')
	<script src="{{ asset('packages/backpack/crud/js/crud.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
	<script src="{{ asset('packages/backpack/crud/js/show.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>

<script>
	enableDisableButton();

	function enableDisableButton()
	{
		if (document.getElementById('terms_check_box').checked){
			$('#submit_confirm_button').removeClass('disabled');
        } else {
			$('#submit_confirm_button').addClass('disabled');
        }
	}

	function submitConfirm()
	{
		$.get('/public/apply-for-membership/'+{{$entry->getKey()}}+'/confirm',function(response){
			if(response.status){
				swal({
					title: "Submisson Successful",
					text: "Form successfully submitted !!",
					icon: "success",
					timer: 3000,
					buttons: false,
				});

				setTimeout(() => {
					window.location.href='/public/apply-for-membership/create';	
				}, 3500);
			}
		})
	}
</script>
@endsection


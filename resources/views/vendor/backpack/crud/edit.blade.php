@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.edit') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid">
	<h3 class="font-weight-700">
        @if(isset($custom_title))
        	<span class="text-capitalize">{{ $custom_title }}</span>
      	@else
			<span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
			<small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
		 @endif
		 
		 @if ($crud->hasAccess('list'))
		 <small><a href="{{ url($crud->route) }}" class="hidden-print back-btn"><i class="la la-angle-double-left"></i> {{ trans('Back') }}</a></small>
		 @endif

		 @if(isset($crud->print_profile_btn))
		 <a target="_blank" href="{{ url($crud->route.'/'.$entry->id.'/print-profile') }}" class="btn btn-primary print-btn float-right mr-5" data-style="zoom-in"><span class="ladda-label"><i class="la la-print"></i>&nbsp; Print Profile</span></a>
		 <a target="_blank" href="{{ url($crud->route.'/profiles/print-all') }}" class="btn btn-primary print-btn float-right mr-2" data-style="zoom-in"><span class="ladda-label"><i class="la la-print"></i>&nbsp; Print All Profiles</span></a>
		 @endif
		</h3>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="{{ $crud->getEditContentClass() }}">
		<!-- Default box -->
	@if(isset($tab_links))
		@include('admin.tab.tab', ['links' => $tab_links])
	@endif

		@include('crud::inc.grouped_errors')

		@if(isset($crud->public_update))
		<form method="post"
		  		action="{{ url($update_url) }}"
				@if ($crud->hasUploadFields('update', $entry->getKey()))
				enctype="multipart/form-data"
				@endif
		  		>
				  {!! method_field('POST') !!}

				<input type="hidden" name="token" value="{{$entry->token}}">
		@else

		  <form method="post"
		  		action="{{ url($crud->route.'/'.$entry->getKey()) }}"
				@if ($crud->hasUploadFields('update', $entry->getKey()))
				enctype="multipart/form-data"
				@endif
		  		>
				  {!! method_field('PUT') !!}

		@endif		
		  {!! csrf_field() !!}

		  	@if ($crud->model->translationEnabled())
		    <div class="mb-2 text-right">
		    	<!-- Single button -->
				<div class="btn-group">
				  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('locale')?request()->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  	<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?locale={{ $key }}">{{ $locale }}</a>
				  	@endforeach
				  </ul>
				</div>
		    </div>
		    @endif
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
		      @else
		      	@include('crud::form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
		      @endif

			@if(backpack_user())
	          @include('crud::inc.form_save_buttons')
			@else
				<button type ="submit" class="btn btn-lg btn-success mb-5 px-5"><i class="la la-floppy-o"></i> Update</button>
			@endif
		  </form>
	</div>
</div>
@endsection


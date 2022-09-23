@php
    if (!isset($field['wrapperAttributes']) || !isset($field['wrapperAttributes']['data-init-function'])){
        $field['wrapperAttributes']['data-init-function'] = 'bpFieldInitUploadMultipleElement';
    }

    if (!isset($field['wrapperAttributes']) || !isset($field['wrapperAttributes']['data-field-name'])) {
        $field['wrapperAttributes']['data-field-name'] = $field['name'];
    }

@endphp

<!-- upload multiple input -->
@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

	{{-- Show the file name and a "Clear" button on EDIT form. --}}
	@if (isset($field['value']))
	@php
		if (is_string($field['value'])) {
			$values = json_decode($field['value'], true) ?? [];
		} else {
			$values = $field['value'];
		}
	@endphp
	@if (count($values))
    <div class="well well-sm existing-file">
		@foreach($values as $key => $file_path)
			@php
				$data = explode('.', $file_path);
				$extension = $data[1];
			@endphp
			@if($extension == 'pdf')
	    		<div class="file-preview mr-5" style="display:inline-flex">
					<a class="fancybox" data-fancybox-type="iframe" href="{{ isset($field['disk'])?asset(\Storage::disk($field['disk'])->url($file_path)):asset($file_path) }}"> <i class="la la-file-pdf la-5x" style="color:red; position:relative;"></i></a>
					<a id="{{ $field['name'] }}_{{ $key }}_clear_button" href="#" class="btn btn-danger btn-sm file-clear-button la la-remove" title="Clear file" data-filename="{{ $file_path }}"></a>
				</div>
			@else
				<div class="file-preview mr-5" style="display:inline-flex">
					<a class="fancybox" rel="gallery" href="{{ isset($field['disk'])?asset(\Storage::disk($field['disk'])->url($file_path)):asset($file_path) }}">
						<img style="max-height:100px; max-width:100x; border-radius:10px;" src="{{ isset($field['disk'])?asset(\Storage::disk($field['disk'])->url($file_path)):asset($file_path) }}" />
					</a>
					<a id="{{ $field['name'] }}_{{ $key }}_clear_button" href="#" class="btn btn-danger btn-sm file-clear-button la la-remove" title="Clear file" data-filename="{{ $file_path }}"></a>
				</div>
			@endif
    	@endforeach
    </div>
    @endif
    @endif
	{{-- Show the file picker on CREATE form. --}}
	<input name="{{ $field['name'] }}[]" type="hidden" value="">
	<div class="backstrap-file mt-2">
		<input
	        type="file"
	        name="{{ $field['name'] }}[]"
	        value="@if (old(square_brackets_to_dots($field['name']))) old(square_brackets_to_dots($field['name'])) @elseif (isset($field['default'])) $field['default'] @endif"
	        @include('crud::fields.inc.attributes', ['default_class' =>  isset($field['value']) && $field['value']!=null?'file_input backstrap-file-input':'file_input backstrap-file-input'])
	        multiple
	    >
        <label class="backstrap-file-label" for="customFile"></label>
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
	@endphp
	
	<style>
		.file-clear-button{
			padding:0 !important;
			font-size:15px !important;
			width:20px !important;
			height:20px !important;
		}
	</style>

	@push('crud_fields_scripts')
	
			<script>
				$(document).ready(function() {
					$(".fancybox").fancybox({
						openEffect  : 'none',
						closeEffect : 'none',
						iframe : {
							preload: false
						}
					});
				});
			</script>

			<!-- no scripts -->
			<script>
				function bpFieldInitUploadMultipleElement(element) {
					var fieldName = element.attr('data-field-name');
					var clearFileButton = element.find(".file-clear-button");
					var fileInput = element.find("input[type=file]");
					var inputLabel = element.find("label.backstrap-file-label");

					clearFileButton.click(function(e) {
						e.preventDefault();
						var container = $(this).parent().parent();
						var parent = $(this).parent();
						// remove the filename and button
						parent.remove();
						// if the file container is empty, remove it
						if ($.trim(container.html())=='') {
							container.remove();
						}
						$("<input type='hidden' name='clear_"+fieldName+"[]' value='"+$(this).data('filename')+"'>").insertAfter(fileInput);
					});

					fileInput.change(function() {
						inputLabel.html("Files selected. After save, they will show up above.");
						// remove the hidden input, so that the setXAttribute method is no longer triggered
						$(this).next("input[type=hidden]").remove();
					});
				}
			</script>
    @endpush
@endif

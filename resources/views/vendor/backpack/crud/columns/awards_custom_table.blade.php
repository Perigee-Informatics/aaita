@php
	$value = data_get($entry, $column['name']);

    // make sure columns are defined
    if (!isset($column['columns'])) {
        $column['columns'] = ['value' => "Value"];
    }

	$columns = $column['columns'];

	// if this attribute isn't using attribute casting, decode it
	if (is_string($value)) {
	    $value = json_decode($value);
    }
@endphp

<style>
	::-webkit-scrollbar {
		width: 10px;
		height: 5px;
	}
	::-webkit-scrollbar-track {
		box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.3);
		border-radius: 10px;
	}

	::-webkit-scrollbar-thumb {
		border-radius: 10px;
		box-shadow: inset 0 0 10px rgb(42, 96, 149);
	}
</style>


<span>
    @if ($value && count($columns))

    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')

    <table class="table table-sm table-bordered table-condensed table-striped m-b-2" style="table-layout:fixed; margin-top:10px !important;">
		<thead>
				@php
					$cols = [
						'award_name' => 200,
						'awarded_by'=> 150,
						'awarded_year' => 50,
                        'name'=>300
					];
				@endphp
			<tr>
                <th style="width:20px; background-color:rgb(128, 186, 243);">S.N.</th>
				@foreach($columns as $tableColumnKey => $tableColumnLabel)
				<th style="{{ 'width:'.$cols[$tableColumnKey].'px; background-color:rgb(128, 186, 243);'}}">{{ $tableColumnLabel }}</th>
				@endforeach
			</tr>
		</thead>

		<tbody>
			@foreach ($value as $tableRow)
				@if((isset($tableRow->award_name) && $tableRow->award_name != '' ) || ((isset($tableRow->name) && $tableRow->name != '')))

					<tr>   
						<td>{{$loop->iteration}}</td>
						@foreach($columns as $tableColumnKey => $tableColumnLabel)
							<td style="overflow-x: scroll; overflow-y:hidden;">
								@if( is_array($tableRow) && isset($tableRow[$tableColumnKey]) )
									{{ $tableRow[$tableColumnKey] }}
								@elseif( is_object($tableRow) && property_exists($tableRow, $tableColumnKey) )
									{!! nl2br($tableRow->$tableColumnKey) !!}

								@endif

							</td>
						@endforeach
					</tr>
				@endif
			@endforeach
		</tbody>
    </table>

    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')

	@endif
</span>

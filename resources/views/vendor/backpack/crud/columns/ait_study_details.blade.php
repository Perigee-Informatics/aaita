@php
	// $value = data_get($entry, $column['name']);

    $levels = [
        'ait_study_details'=>data_get($entry,'ait_study_details'),
];


    // make sure columns are defined
    if (!isset($column['columns'])) {
        $column['columns'] = ['value' => "Value"];
    }

	$columns = $column['columns'];

	// if this attribute isn't using attribute casting, decode it
	    $values = [json_decode($levels['ait_study_details'])];
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
    @if ($values && count($columns))

    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')

    <table class="table table-sm table-bordered table-condensed table-striped m-b-2" style="table-layout:fixed; margin-top:10px !important;">
		<thead>
				@php
					$cols = [
                        'academic_level'=> 100,
                        'name_of_degree' => 100,
                        'name_of_school' => 100,
                        'name_of_other_school' => 100,
                        'field_of_study' =>200,
                        'graduation_year' => 80,
					];
				@endphp
			<tr>
				@foreach($columns as $tableColumnKey => $tableColumnLabel)
				<th style="{{ 'width:'.$cols[$tableColumnKey].'px; background-color:rgb(128, 186, 243);'}}">{{ $tableColumnLabel }}</th>
				@endforeach
			</tr>
		</thead>

		<tbody>
            @foreach($values as $value)
                @foreach ($value as $tableRow)
                <tr>   
                    @foreach($columns as $tableColumnKey => $tableColumnLabel)
                        <td style="overflow-x: scroll; overflow-y:hidden;">
                            @if( is_array($tableRow) && isset($tableRow[$tableColumnKey]) )
                                {{ $tableRow[$tableColumnKey] }}
                            @elseif( is_object($tableRow) && property_exists($tableRow, $tableColumnKey) )
							@php
							switch($tableColumnKey){
								case 'academic_level':
									$column_value = App\Models\Member::$degree_options[($tableRow->$tableColumnKey)];
								break;
								case 'name_of_school':
									$column_value = App\Models\Member::$school_options[($tableRow->$tableColumnKey)];
								break;
								default:
									$column_value = wordwrap($tableRow->$tableColumnKey,60, "<br/>", false);
								break;
								}
							@endphp	
							{!! nl2br($column_value) !!}

                            @endif

                        </td>
                    @endforeach
                </tr>
			@endforeach
			@endforeach
		</tbody>
    </table>

    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')

	@endif
</span>

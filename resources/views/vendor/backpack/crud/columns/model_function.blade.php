{{-- custom return value --}}
@php
    $value = $entry->{$column['function_name']}(...($column['function_parameters'] ?? []));
    
    $column['escaped'] = $column['escaped'] ?? false;
    $column['limit']   = $column['limit'] ?? 250;
    $column['prefix']  = $column['prefix'] ?? '';
    $column['suffix']  = $column['suffix'] ?? '';
    $column['text']    = $column['prefix'].
                         Str::limit($value, $column['limit'], "[...]").
                         $column['suffix'];
@endphp

<span style="{{isset($column['style']) ? $column['style'] : ''}}">
	@includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        @if($column['escaped'])
            {!! nl2br($column['text']) !!}
        @else
            {!! nl2br($column['text']) !!}
        @endif
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>

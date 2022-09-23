{{-- regular object attribute --}}
@php
    $column['escaped'] = $column['escaped'] ?? true;
    $column['decimals'] = $column['decimals'] ?? 0;
    $column['prefix'] = $column['prefix'] ?? '';
    $column['suffix'] = $column['suffix'] ?? '';

    $value = data_get($entry, $column['name']);
    if (!is_null($value)) {
    }
    $column['text'] = is_null($value) ? '' : $value.$column['suffix'];
@endphp

<span style="{{isset($column['style']) ? $column['style'] : ''}}">
	@includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        @if($column['escaped'])
        {{ $column['prefix']}}@englishToNepali($column['text'])
        @else
        {{ $column['prefix']}}@englishToNepali($column['text'])
        @endif
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>

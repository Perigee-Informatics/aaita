{{-- @php
    $value = data_get($entry, $column['name']);
    $column['prefix'] = $column['prefix'] ?? '';
    $column['escaped'] = $column['escaped'] ?? true;
    $column['wrapper']['element'] = $column['wrapper']['element'] ?? 'a';
    $column['wrapper']['target'] = $column['wrapper']['target'] ?? '_blank';
    dd($value);
@endphp

<span>
    @if ($value && count($value))
        @foreach ($value as $file_path)
        @php
            $column['wrapper']['href'] = $column['wrapper']['href'] ?? ( isset($column['disk'])?asset(\Storage::disk($column['disk'])->url($file_path)):asset($column['prefix'].$file_path) );
            $text = $column['prefix'].$file_path;
        @endphp
            @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
            @if($column['escaped'])
                - {{ $text }} <br/>
            @else
                - {!! $text !!} <br/>
            @endif
        @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
        @endforeach
    @else
        -
    @endif
</span> --}}

@php
    $value = data_get($entry, $column['name']);

    if (is_string($value)) {
        $values = json_decode($value, true) ?? [];
    } else {
        $values = $value;
    }
@endphp
<span>
    @if ($values && count($values))
        @foreach ($values as $file_path)

        @php
            $data = explode('.', $file_path);
            $extension = $data[1];
            //  dd($extension);	 
        @endphp

        @if($extension == 'pdf')
            <a href="{{asset('storage/uploads/'. $file_path)}}" target='_blank'><i class="fa fa-file-pdf-o fa-2x text-danger text-decoration-none"></i></a>
        @else
           <a href="{{asset('storage/uploads/'. $file_path)}}" target='_blank'>
            <img src="{{asset('storage/uploads/'. $file_path)}}" height='30px' width='30px'>
        @endif
        @endforeach
    @else
        ----
    @endif
</span>

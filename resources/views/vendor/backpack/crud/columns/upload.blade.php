@php
    $file_path = data_get($entry, $column['name']);
@endphp
<span>
    @if ($file_path)
        <?php
        $data = explode('.', $file_path);
		$extension = $data[1];
        $path=$data[0];
        // dd($file_path);
        ?>
        @if($extension == 'pdf')
        <a href="{{asset('storage/uploads/'. $file_path)}}" target='_blank'><i class="la la-file-pdf-o" style="color:red;"></i></a>
    @else
    <a href="{{asset('storage/uploads/'. $file_path)}}" target='_blank'>
        <img src="{{asset('storage/uploads/'. $file_path)}}" height='70px' width='70px'>
        </a>
        @endif
    @else
        ----
    @endif
</span>

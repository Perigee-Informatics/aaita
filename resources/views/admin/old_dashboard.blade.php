@extends(backpack_view('layouts.top_left'))
@php
	if (isset($widgets)) {
		foreach ($widgets as $section => $widgetSection) {
			foreach ($widgetSection as $key => $widget) {
				\Backpack\CRUD\app\Library\Widget::add($widget)->section($section);
			}
		}
	}
@endphp
@section('content')
    <div class="row">
        <div class="col">
            <div class="card" style="background-color:#d9d9d9">
                <div class="card-header bg-primary p-1">
                  <div class="row">
                    <div class="col-md-7">
                        <i class="la la-chart-pie"> <i class="la la-chart-bar"></i> Charts</i>
                    </div>
                    <div class="col">
                        <table>
                            <tr>
                                <td style="text-align:right"><span class="font-weight-bold">Fiscal Year :</span></td>
                                <td style="text-align:left">
                                    <div>
                                        <select class="form-control searchselect" name="fiscal_year_id" id="fiscal_year_id" onchange="filterChartData()">
                                            @if(isset($fiscal_year_id))
                                                <option value="all" selected>All</option>
                                                @foreach ($fiscal_year as $option)
                                                    @if(intval($fiscal_year_id) === $option->getKey())
                                                        <option value="{{ $fiscal_year_id }}" selected }}>{{ $option->code }}</option>
                                                    @else
                                                        <option value="{{ $option->getKey() }}" >{{ $option->code }}</option>
                                                    @endif    
                                                @endforeach
                                            @else
                                                <option value="all" selected>All</option>
                                                @foreach ($fiscal_year as $option)
                                                        <option value="{{ $option->getKey() }}" >{{ $option->code }}</option>
                                                @endforeach
                                            @endif    
                                        </select>
                                        <a href="javascript:;" id="reset_button" class="btn btn-sm btn-warning text-dark" onclick="resetFilter()" data-style="zoom-in"><span class="ladda-label"><i class="la la-refresh"></i> Reset</span></a>
                                    </div>
                                </td>
                                <td>
                                </td>
                            </tr>
                        </table>
                    </div>
                  </div>
                </div>
                <div class="mt-4 ml-5 mr-5" id="charts-section">
                    @include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'before_content')->toArray() ])
                </div>

                <div class="m-2" id="charts-section">
                    @include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'after_content')->toArray() ])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after_scripts')
<script>
    function filterChartData(){
    let fiscal_year_id = $('#fiscal_year_id').val();
        window.location.href = '/admin/project-charts?fiscal_year_id='+fiscal_year_id;
    }
    function resetFilter(){
        window.location.href = '/admin/project-charts';
    }
</script>
@endpush







   

    

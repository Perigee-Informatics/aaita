let {{ $chart->id }}_rendered = false;
@if ($chart->api_url)
let {{ $chart->id }}_api_url = "{!! $chart->api_url !!}";
@endif
let {{ $chart->id }}_load = function () {
    if (document.getElementById("{{ $chart->id }}") && !{{ $chart->id }}_rendered) {
        @if ($chart->api_url)
            fetch({{ $chart->id }}_api_url)
                .then(data => data.json())
                .then(data => { {{ $chart->id }}_create(data) });
        @else
            {{ $chart->id }}_create({!! $chart->formatDatasets() !!})
        @endif
    }
};
window.addEventListener("load", {{ $chart->id }}_load);
document.addEventListener("turbolinks:load", {{ $chart->id }}_load);


{{-- js extra code for on click event to pie chart --}}
$('#{{ $chart->id }}').click(function(event){

    {{-- get fiscal year id from session --}}
    let fiscal_year_id = "{{ Session::get('fiscal_year_id') }}";
    if(event.originalEvent.point){
        let new_path = event.originalEvent.point;
        if(new_path.series.userOptions.type === 'column'){

            let chart_name = new_path.series.userOptions.chart_name;

            {{-- make an action according to chart name--}}
            switch(chart_name){
                case 'project_by_province':
                case 'project_by_cost':
                        let province_id = new_path.series.userOptions.province_id;
                        if(fiscal_year_id != ''){
                            window.open("{{ backpack_url('ptproject') }}?fiscal_year_id="+fiscal_year_id+"&province_id="+province_id); 
                        }else{
                            window.open("{{ backpack_url('ptproject') }}?province_id="+province_id); 
                        }
                    break;
                case 'project_by_category':
                case 'project_by_category_cost':
                        let category_id = new_path.series.userOptions.category_id;
                        if(fiscal_year_id != ''){
                            window.open("{{ backpack_url('ptproject') }}?fiscal_year_id="+fiscal_year_id+"&category_id="+category_id);
                        }else{
                            window.open("{{ backpack_url('ptproject') }}?category_id="+category_id);
                        }
                    break;
            }           
                                      
        }else{
            let id = event.originalEvent.point.id;
            if(fiscal_year_id != ''){
                switch(id){
                    case 1:
                        window.open("{{ backpack_url('newproject') }}?fiscal_year_id="+fiscal_year_id);
                    break;
                    case 2:
                        window.open("{{ backpack_url('ptproject') }}?fiscal_year_id="+fiscal_year_id);
                    break;
                    case 3:
                        window.open("{{ backpack_url('ptproject') }}?fiscal_year_id="+fiscal_year_id+"&status=work_in_progress");
                    break;
                    case 4:
                        window.open("{{ backpack_url('ptproject') }}?fiscal_year_id="+fiscal_year_id+"&status=completed");
                    break;
                }
            }else{
                switch(id){
                    case 1:
                        window.open("{{ backpack_url('newproject') }}");
                    break;
                    case 2:
                        window.open("{{ backpack_url('ptproject') }}");
                    break;
                    case 3:
                        window.open("{{ backpack_url('ptproject') }}?status=work_in_progress");
                    break;
                    case 4:
                        window.open("{{ backpack_url('ptproject') }}?status=completed");
                    break;
                }

            }
        }
    }
});
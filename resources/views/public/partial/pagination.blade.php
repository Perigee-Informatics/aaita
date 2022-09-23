@php
    $link_limit = 10;
    $paginator->appends(request()->query());
@endphp
@if ($paginator->lastPage() > 1)
<nav aria-label="Pagination" style="float:right">
    <ul class="pagination">
      <li class="page-item disabled">
        <a class="page-link font-weight-600 text-blue" href="#" tabindex="-1" aria-disabled="true"> {{ 'Total Rows : '. $data->total() }} </a>
      </li>
      <li class="disabled">
        <span  href="#" tabindex="-1" aria-disabled="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </li>

      <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
        <a class="page-link font-weight-600" data-href="{{ $paginator->url(1) }}" onclick="getMembersData(1)" tabindex="-1" aria-disabled="true">First</a>
      </li>
      @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        @php
            $half_total_links = floor($link_limit / 2);
            $from = $paginator->currentPage() - $half_total_links;
            $to = $paginator->currentPage() + $half_total_links;
            if ($paginator->currentPage() < $half_total_links) {
                $to += $half_total_links - $paginator->currentPage();
            }
            if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
            }
        @endphp
        @if ($from < $i && $i < $to)
            <li class="{{ ($paginator->currentPage() == $i) ? 'page-item active' : 'page-item' }} "><a class="page-link" data-href="{{ $paginator->url($i) }}" onclick="getMembersData({{$i}})">
                    {{$i}}
            </a></li>
        @endif
      @endfor
      <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
        <a class="page-link font-weight-600" data-href="{{ $paginator->url($paginator->lastPage()) }}" onclick="getMembersData({{$paginator->lastPage()}})" >Last</a>
      </li>
    </ul>
  </nav>
@endif

<style>
  .page-link{
    color:blue !important;
  }
  .page-item{
    cursor: pointer;
  }
  .font-weight-600{
    font-weight: 600;
  }
  .page-item.disabled .page-link{
    background-color: rgb(230, 227, 227) !important;
  }
  .page-item.active .page-link{
    background-color: rgb(28, 116, 146) !important;
    color:white !important;
    font-weight: bold;
  }
</style>








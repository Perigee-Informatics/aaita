<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">

<head>
  @include(backpack_view('inc.head'))
</head>

<body class="{{ config('backpack.base.body_class') }}">

  @include(backpack_view('inc.main_header'))
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

  <div class="app-body">

    @include(backpack_view('inc.sidebar'))

    <main class="main pt-2">

       @includeWhen(isset($breadcrumbs), backpack_view('inc.breadcrumbs'))

       @yield('header')

        <div class="container-fluid animated fadeIn">

          @yield('before_content_widgets')

          @yield('content')
          
          @yield('after_content_widgets')

        </div>

    </main>

  </div><!-- ./app-body -->

  <footer class="{{ config('backpack.base.footer_class') }}">
    @include(backpack_view('inc.footer'))
  </footer>

  @yield('before_scripts')
  @stack('before_scripts')

  @include(backpack_view('inc.scripts'))

<!-- pivot table scripts -->

<script src="{{ asset('packages/pivotlatest/ploty-basic-latest-min.js')}}"></script>
<script type="text/javascript" src="{{ asset('packages/pivotlatest/jqueryui/jquery-ui-min.js')}}"></script>

<!-- PivotTable.js libs from /packages/pivotlatest/dist -->
<link rel="stylesheet" type="text/css" href="{{ asset('packages/pivotlatest/dist/pivot.css')}}">
<script type="text/javascript" src="{{ asset('packages/pivotlatest/dist/pivot.js')}}"></script>
<script type="text/javascript" src="{{ asset('packages/pivotlatest/dist/plotly_renderers.js')}}"></script>
<!-- optional: mobile support with jqueryui-touch-punch -->
<script type="text/javascript" src="{{ asset('packages/pivotlatest/jqueryui-touch-punch/jquery.ui.touch-punch-min.js')}}"></script>

<!-- pivot table scripts ends -->

  @yield('after_scripts')
  @stack('after_scripts')
  <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="{{ asset('js/nepali.datepicker.v2.2.min.js') }}"></script>
</body>
</html>
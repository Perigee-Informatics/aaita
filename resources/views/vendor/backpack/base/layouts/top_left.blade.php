<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">

<head>
  @include(backpack_view('inc.head'))
  @if(empty($load_css))
  <!-- do nothing -->
  <!-- <p>Data does not exist</p> -->
  @else
  <!-- loop through the scripts -->
  @foreach($load_css as $css)
  <!-- <script type="text/javascript" src="{{ $css }}"></script> -->
  <link rel="stylesheet" href="{{ $css }}">
  <!-- <p>Your data is here!</p> -->
  @endforeach
  @endif

  @if(empty($style_css))
  <!-- do nothing -->
  <!-- <p>Data does not exist</p> -->
  @else
  <style>
  {{$style_css}}
  </style>
  @endif
</head>

<body class="{{ config('backpack.base.body_class') }}">

  @include(backpack_view('inc.main_header'))

  <div class="app-body">

    @include(backpack_view('inc.sidebar'))

    <main class="main pt-4 pl-3">

       @yield('before_breadcrumbs_widgets')

       @includeWhen(isset($breadcrumbs), backpack_view('inc.breadcrumbs'))

       @yield('after_breadcrumbs_widgets')

       @yield('header')

        <div class="container-fluid animated fadeIn">

          @yield('before_content_widgets')

          @yield('content')
          
          @yield('after_content_widgets')

        </div>

    </main>

  </div><!-- ./app-body -->

  {{-- <footer class="{{ config('backpack.base.footer_class') }}">
    @include(backpack_view('inc.footer'))
  </footer> --}}

  @yield('before_scripts')
  @stack('before_scripts')

  @include(backpack_view('inc.scripts'))

  @yield('after_scripts')
  @stack('after_scripts')

  @if(empty($load_scripts))
  <!-- do nothing -->
  <!-- <p>Data does not exist</p> -->
  @else
  <!-- loop through the scripts -->
  @foreach($load_scripts as $script)
  <script type="text/javascript" src="{{ $script }}"></script>
  <!-- <p>Your data is here!</p> -->
  @endforeach
  @endif
  @if(empty($script_js))
  <!-- do nothing -->
  <!-- <p>Data does not exist</p> -->
  @else
  <script>
  {!! html_entity_decode($script_js) !!}
  </script>
  @endif
</body>
</html>
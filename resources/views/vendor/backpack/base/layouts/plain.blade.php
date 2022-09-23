<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">
<head>
    @include(backpack_view('inc.head'))
</head>
<body class="{{ config('backpack.base.body_class') }}">
  @include(backpack_view('inc.main_header'))

  <div class="app-body">
  @include(backpack_view('inc.sidebar'))

    {{-- <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <a href="/"><i class="la la-sitemap"></i>  Graphical</a>
      <a href="/public/list-members"><i class="la la-table"></i>  Tabular</a>
    </div> --}}
    <main class="main pt-4 pl-3">

      {{-- <div class="pl-3"> --}}
        @yield('content')
      {{-- </div> --}}
    </main>
  </div>
 
  @yield('before_scripts')
  @stack('before_scripts')

  @include(backpack_view('inc.scripts'))

  @yield('after_scripts')
  @stack('after_scripts')

</body>
</html>

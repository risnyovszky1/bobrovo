

@include('admin.header')
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-2 col-md-3 pl-0 pr-0 full-height-lg bg-bobrovo-orange-light">
          @include('admin.side_menu')
        </div>
        <div class="col-lg-10 col-md-9 bg-bobrovo-orange-light">
          @yield('admin_content')
        </div>
      </div>
    </div>

    <div class="additional-html-wrapper">
      @yield('additional_html')
    </div>
  </body>
</html>

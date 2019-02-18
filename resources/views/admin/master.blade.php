

@include('admin.header')

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-2 col-md-3 pl-0 pr-0">
          @include('admin.side_menu')


        </div>
        <div class="col-lg-10 col-md-9">
          @yield('admin_content')
        </div>
      </div>
    </div>
  </body>
</html>

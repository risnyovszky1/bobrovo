@include('admin.header')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-3 pl-md-0 full-height-lg bg-bobrovo-orange-light">
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

<footer id="footer-bobrovo">
    <div class="post-footer bg-dark text-light pt-2 pb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 white-links">
                    <p class="lead mb-0">
                        Stránku vytvoril <a href="mailto:risnyo96@gmail.com"><strong>András Risnyovszký</strong></a> ako
                        bakalárskú prácu v FMFI UK <sup>&copy;</sup>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>

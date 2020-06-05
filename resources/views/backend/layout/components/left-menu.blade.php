<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{url('/admin/dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard</a>
                <div class="sb-sidenav-menu-heading">Interface</div>


                <a class="nav-link" href="{{url('/admin/films')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-film"></i></div>
                    Films
                </a>
                <a class="nav-link" href="{{url('/admin/hall')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    Hall
                </a>
                @if(Auth::user()->role === 'admin')
                    <a class="nav-link" href="{{url('/admin/setting')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                        Settings
                    </a>
                @endif

                {{--            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts"--}}
                {{--               aria-expanded="false" aria-controls="collapseLayouts">--}}
                {{--                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>--}}
                {{--                Layouts--}}
                {{--                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
                {{--            </a>--}}
                {{--            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"--}}
                {{--                 data-parent="#sidenavAccordion">--}}
                {{--                <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="layout-static.html">Static--}}
                {{--                        Navigation</a><a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>--}}
                {{--                </nav>--}}
                {{--            </div>--}}

            </div>
        </div>
    </nav>
</div>

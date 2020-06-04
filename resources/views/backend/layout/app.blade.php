<!doctype html>
<html lang="en">
@include('backend.layout.components.head')
@stack('after-style')
<body class="@stack('body-class','sb-nav-fixed')">
@include('backend.layout.components.header')
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        @include('backend.layout.components.left-menu')
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">@stack('page','')</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">@stack('page','')</li>
                </ol>
                @yield('content')
            </div>
        </main>
        @include('backend.layout.components.footer')
    </div>
</div>
@stack('modal')
@include('backend.layout.components.script')
@stack('after-script')
</body>
</html>

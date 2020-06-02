<!doctype html>
<html lang="en">
@include('backend.layout.components.head')
@stack('after-style')
<body class="@stack('body-class','sb-nav-fixed')">
@include('backend.layout.components.header')
<div id="layoutSidenav">
    @include('backend.layout.components.left-menu')
    @yield('content')
</div>
@include('backend.layout.components.script')
@stack('after-script')
</body>
</html>

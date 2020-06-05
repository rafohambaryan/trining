<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{csrf_token()}}">
    <title>@stack('title','Admin')</title>
    @include('backend.layout.components.head')
    @stack('after-style')
</head>
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

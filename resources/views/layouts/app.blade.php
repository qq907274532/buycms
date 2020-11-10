<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <!-- <link rel="dns-prefetch" href="https://fonts.gstatic.com"> -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css"> -->


        <link rel="stylesheet" href="{{ asset('admin/layui/css/layui.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/AdminLTE/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/AdminLTE/dist/css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/AdminLTE/dist/css/skins/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/iCheck/all.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/scojs/sco.message.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
        @yield('css')
        @section('css')
            <style>
                .red{
                    color: red;
                }
            </style>
        @endsection
    </head>

    <body class="" onload="$('body').height($('html').height())">
        <div class="wrapper">
            <!-- Content Wrapper. Contains page content -->
            <!-- Content Header (Page header) -->
            @section('breadcrumb')
            <section class="content-header">
                <h1>
                    @yield('header')
                    <small>@yield('header.description')</small>
                </h1>
                <!--
                <ol class="breadcrumb">
                    <li><a href=""><i class="fa fa-dashboard"></i> 首页</a></li>
                    <li class="active">Dashboard</li>
                </ol>
                -->
            </section>
            @show

            <section class="content">
                @yield('content')
            </section>
        </div>
        <script src="{{ asset('admin/jQuery/jquery-2.2.3.min.js') }}"></script>
        <script src="{{ asset('admin/AdminLTE/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('admin/AdminLTE/dist/js/app.min.js') }}"></script>
        <script src="{{ asset('admin/iCheck/icheck.min.js') }}"></script>
        <script src="{{ asset('admin/bootbox/bootbox.all.min.js') }}"></script>
        <script src="{{ asset('admin/layui/layui.all.js') }}"></script>
        <script src="{{ asset('js/admin.js') }}?v={{ \App\Services\HelperService::random_number(9)}}"></script>
        <script src="{{ asset('admin/scojs/sco.message.js') }}" type="text/javascript"></script>
        @if ( session('message') )
        <script type="text/javascript">
            $(function(){$.scojs_message('{{ session('message') }}',{{ session('message_type') }})});
        </script>
        @endif
        @yield('js')
    </body>
</html>

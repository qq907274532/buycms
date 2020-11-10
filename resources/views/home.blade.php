<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('admin.name', config('app.name')) }}</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{ asset('admin/AdminLTE/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/AdminLTE/dist/css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/AdminLTE/dist/css/skins/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    </head>


    <body class="{{ config('admin.skin') }} fixed" style="overflow-y: hidden;">
        <div class="wrapper">
            <header class="main-header">
                <a href="{{ url('/') }}" class="logo">
                    <span class="logo-mini">{!! config('admin.logo-mini') !!}</span>
                    <span class="logo-lg">{!! config('admin.logo', config('admin.name')) !!}</span>
                </a>
                <nav class="navbar navbar-static-top" id="navbarSupportedContent">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="hidden-xs">{{ Auth::user()->username }}</span>
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">

                                    <li><a href="{{ asset('account/profile') }}" target="mainFrame">个人设置</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ asset('logout') }}">登出</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            @include('sidebar')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <iframe id="mainFrame" name="mainFrame" src="{{ asset(config('admin.homepage')) }}" width="100%" height="100%" frameborder="0" scrolling="yes"></iframe>
            </div>

            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                </div>
                <strong>Copyright &copy; 2018 <a href="#">admin</a>.</strong> All rights reserved.
            </footer>
        </div>

        <script src="{{ asset('admin/jQuery/jquery-2.2.3.min.js') }}"></script>
        <script src="{{ asset('admin/AdminLTE/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('admin/AdminLTE/dist/js/app.min.js') }}"></script>
        <script src="{{ asset('admin/slimScroll/jquery.slimscroll.min.js') }}"></script>

        <script>
            var windowHeight = $(window).height();
            var headerHeight = $(".main-header").height();
            var footerHeight = $(".main-footer").height() + 30;
            $("#mainFrame").height(windowHeight - headerHeight - footerHeight)
            // $(".sidebar-menu").height(windowHeight - headerHeight - footerHeight).css("overflow-x", "scroll");
            //console.log($(window).height() - $(".main-header").height() - $(".main-footer").height())
            //console.log("mainHeader:" + $(".main-header").height())
            //console.log("mainFooter:" + $(".main-footer").height())
            //iframe加载计算window height
            //$("#mainFrame").load(function(){
            //      var iframeHeight = $(this).contents().find("body").height(),
            //      mainBodyHeight = $('.main-sidebar').height() + $('.navbar').height();
            //      var mainheight =  iframeHeight > mainBodyHeight ? iframeHeight : mainBodyHeight;
            //
            //      if(mainheight < $(window).height() - $('.navbar').height()) {
            //      mainheight = $(window).height();
            //  }
            //
            //  console.log('windowHeight:' + $(window).height())
            //  console.log('navHeight:' + $('.navbar').height())
            //  console.log('iframeHeight:' + iframeHeight)
            //  console.log('mainBodyHeight:' + mainBodyHeight)
            //  console.log('mainheight:' + mainheight)
            //  console.log('sidenavHeight:' + $('#sidebar-nav').height())
                //  $(this).height(mainheight);
                //  $(window).scrollTop(0);
            //});
            //
        </script>
    </body>
</html>

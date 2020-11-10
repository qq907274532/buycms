<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', '管理平台') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('admin/AdminLTE/bootstrap/css/bootstrap.min.css') }}">

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="https://fonts.gstatic.com"> -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css"> -->

    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="/static/plugins/ionicons/css/ionicons.min.css"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/AdminLTE/dist/css/AdminLTE.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href=""><b>{{ config('app.name', 'Laravel') }}</b></a>
    </div>
  <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">请登录</p>
        <p class="alert-error">
            @foreach($errors->all() as $error)
            {{ $error }}</br>
            @endforeach
        </p>

        <form action="{{ route('login') }}" method="post">

            @csrf
            <div class="form-group has-feedback">
                <input type="text" name="username" class="form-control" id="username" placeholder="用户名">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control "  placeholder="密码">

            </div>
            <div class="form-group has-feedback">
                <div style="width:55%" >
                <input type="text" class="form-control {{$errors->has('captcha')?'parsley-error':''}}" name="captcha" placeholder="captcha" >
                </div>
                <div style="width:37%;margin-top: -36px" class="pull-right">
                <img src="{{captcha_src()}}" style="cursor: pointer" onclick="this.src='{{captcha_src()}}'+Math.random()" >
                </div>
            </div>
           
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4 col-md-offset-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
                <!-- /.col -->
            </div>

        </form>
  </div>
  <!-- /.login-box-body -->
</div>

<!-- /.login-box -->
</body>
</html>
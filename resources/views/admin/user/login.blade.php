<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/static/admin/css/main.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/static/admin/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/static/admin/css/modify.css') }}">

    <title>有趣的灵魂后台管理系统 - 登陆</title>
</head>
<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        <h1>有趣的灵魂后台</h1>
    </div>
    <div class="login-box">
        <form class="login-form" action="{{ route('admin.user.do_login') }}" method="post">
            {{ csrf_field() }}
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>登 陆</h3>
            <div class="form-group">
                <label class="control-label">用户名</label>
                <input class="form-control" type="text" name="username" placeholder="请输入" autofocus>
            </div>
            <div class="form-group">
                <label class="control-label">密　码</label>
                <input class="form-control" type="password" name="password" placeholder="请输入">
            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>登 陆</button>
            </div>
        </form>
    </div>
</section>
</body>
</html>
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>有趣的灵魂中文小说网 - @yield('title')</title>
    <meta name="keywords" content="各种类型的小说，玄幻奇幻，武侠仙侠，都市言情，历史军事，科幻灵异，网游竞技，女频频道">
    <meta name="description" content="各种类型的小说，热血，奇异，幽默等各种需求都可满足于你">
    <link rel="stylesheet" type="text/css" href="{{ asset('/static/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/static/css/nprogress.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/static/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/static/css/font-awesome.min.css') }}">
    <link rel="apple-touch-icon-precomposed" href="images/icon.png">
    <link rel="shortcut icon" href="{{ asset('/static/images/favicon.ico') }}">
    <script src="{{ asset('/static/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('/static/js/nprogress.js') }}"></script>
    <script src="{{ asset('/static/js/jquery.lazyload.min.js') }}"></script>
    <!--[if gte IE 9]>
    <script src="{{ asset('/static/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/static/js/html5shiv.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/static/js/respond.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/static/js/selectivizr-min.js') }}" type="text/javascript"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script>alert("浏览器版本过低");</script>
    <![endif]-->

    @yield('otherStaticFirst')
</head>
<body class="user-select">



@yield('content')




<script src="{{ asset('/static/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/static/js/jquery.ias.js') }}"></script>
<script src="{{ asset('/static/js/scripts.js') }}"></script>

@yield('otherStaticSecond')

</body>
</html>

<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $_common_['seo.title'] }} - @yield('title')</title>
    <meta name="keywords" content="{{ $_common_['seo.keywords'] }}">
    <meta name="description" content="{{ $_common_['seo.description'] }}">
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1,user-scalable=no">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="apple-touch-icon-precomposed" href="{{ asset('/favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('/mobile/static/bootstrap/css/bootstrap.min.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('/mobile/static/layer/need/layer.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('/mobile/static/css/style.css') }}">

    @yield('otherStaticFirst')
</head>
<body>

@yield('content')

<script src="{{ asset('/mobile/static/js/jquery.min.js') }}"></script>
<script src="{{ asset('/mobile/static/bootstrap/js/bootstrap.min.js') }}"></script>
{{--<script src="{{ asset('/mobile/static/layer/layer.js') }}"></script>--}}
<script src="{{ asset('/mobile/static/js/common.js') }}"></script>

@yield('otherStaticSecond')

</body>
</html>

<header class="header">
    <nav class="navbar navbar-default" id="navbar">
        <div class="container">
            {{--<div class="header-topbar hidden-xs link-border">--}}
                {{--<ul class="site-nav topmenu">--}}
                    {{--<li><a href="#">标签云</a></li>--}}
                    {{--<li><a href="#" rel="nofollow">读者墙</a></li>--}}
                    {{--<li><a href="#" title="RSS订阅">--}}
                            {{--<i class="fa fa-rss"> </i> RSS订阅--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--勤记录 懂分享--}}
            {{--</div>--}}
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#header-navbar" aria-expanded="false"><span class="sr-only"></span> <span
                            class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                </button>
                <h1 class="logo hvr-bounce-in">
                    <a href="{{ route('index') }}" title="">
                        <img src="{{ asset('/static/images/logo.jpg') }}" alt="">
                    </a>
                </h1>
            </div>
            <div class="collapse navbar-collapse" id="header-navbar">
                <form class="navbar-form visible-xs" action="/Search" method="post">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="请输入关键字" maxlength="20" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-search" name="search" type="submit">搜索</button>
                        </span>
                    </div>
                </form>
                <!--{{ $routeName = \Illuminate\Support\Facades\Route::currentRouteName() }}-->
                <ul class="nav navbar-nav navbar-right">
                    <li @if($routeName == 'index') class="active" @endif><a data-cont="首页" title="首页" href="{{ route('index') }}">首页</a></li>
                    <li @if($routeName == 'article-index' && request()->category_id == 1) class="active" @endif><a data-cont="玄幻奇幻" title="玄幻奇幻" href="{{ route('article-index', ['category_id' => 1]) }}">玄幻奇幻</a></li>
                    <li @if($routeName == 'article-index' && request()->category_id == 2) class="active" @endif><a data-cont="武侠仙侠" title="武侠仙侠" href="{{ route('article-index', ['category_id' => 2]) }}">武侠仙侠</a></li>
                    <li @if($routeName == 'article-index' && request()->category_id == 3) class="active" @endif><a data-cont="都市言情" title="都市言情" href="{{ route('article-index', ['category_id' => 3]) }}">都市言情</a></li>
                    <li @if($routeName == 'article-index' && request()->category_id == 4) class="active" @endif><a data-cont="历史军事" title="历史军事" href="{{ route('article-index', ['category_id' => 4]) }}">历史军事</a></li>
                    <li @if($routeName == 'article-index' && request()->category_id == 5) class="active" @endif><a data-cont="科幻灵异" title="科幻灵异" href="{{ route('article-index', ['category_id' => 5]) }}">科幻灵异</a></li>
                    <li @if($routeName == 'article-index' && request()->category_id == 6) class="active" @endif><a data-cont="网游竞技" title="网游竞技" href="{{ route('article-index', ['category_id' => 6]) }}">网游竞技</a></li>
                    <li @if($routeName == 'article-index' && request()->category_id == 7) class="active" @endif><a data-cont="女频频道" title="女频频道" href="{{ route('article-index', ['category_id' => 7]) }}">女频频道</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
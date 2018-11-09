<header class="header">
    <nav class="navbar navbar-default" id="navbar">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#header-navbar" aria-expanded="false"><span class="sr-only"></span> <span
                            class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                </button>
                <h1 class="logo hvr-bounce-in">
                    <a href="{{ route('index') }}" title="有趣的灵魂">
                        @if(isset($_common_['logo']) && ! empty($_common_['logo']))
                            <img width="168" height="42" src="{{ asset($_common_['logo']) }}" alt="有趣的灵魂">
                        @endif
                    </a>
                </h1>
            </div>
            <div class="collapse navbar-collapse" id="header-navbar">
                <form class="navbar-form visible-xs" action="{{ route(request()->route()->getName(), ['keyword' => request()->get('keyword'), 'category_id' => request()->category_id]) }}" method="get">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" value="{{ request()->get('keyword') }}" placeholder="请输入关键字" maxlength="20" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-search" type="submit">搜索</button>
                        </span>
                    </div>
                </form>
                <?php $routeName = \Illuminate\Support\Facades\Route::currentRouteName(); ?>
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
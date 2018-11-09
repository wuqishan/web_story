@extends('home.common.base')

@section('title'){{ $results['seo.title'] }}@endsection

@section('content')
    @include('home.common.header')
    <section class="container">
        <div class="content-wrap">
            <div class="content">
                <div id="focusslide" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#focusslide" data-slide-to="0" class="active"></li>
                        <li data-target="#focusslide" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        @if(isset($_common_['banner']) && count($_common_['banner']) > 0)
                            @foreach($_common_['banner'] as $k => $v)
                                <div class="item @if($k === 0) active @endif">
                                    <a href="javascript:void(0);" target="_blank" title="有趣的灵魂">
                                        <img height="200" width="820" src="{{ $v }}" alt="有趣的灵魂" class="img-responsive">
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <a class="left carousel-control" href="#focusslide" role="button" data-slide="prev" rel="nofollow">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">上一个</span>
                    </a>
                    <a class="right carousel-control" href="#focusslide" role="button" data-slide="next" rel="nofollow">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">下一个</span>
                    </a>
                </div>
                @foreach($results['book_update']['list'] as $v)
                    <article class="excerpt excerpt-1">
                        <a class="focus" href="{{ route('chapter-list', ['unique_code' => $v['unique_code']]) }}" data-toggle="tooltip" title="" target="_blank">
                            <img class="thumb" src="{{ $v['image_local_url'] }}" style="display: inline;">
                        </a>
                        <header>
                            <h2>
                                <a href="{{ route('chapter-list', ['unique_code' => $v['unique_code']]) }}" title="{{ $v['title'] }}" target="_blank">{{ $v['title'] }}</a>
                            </h2>
                        </header>
                        <p class="meta">
                            <time class="time"><i class="glyphicon glyphicon-time"></i> {{ $v['last_update'] }}</time>
                            <span class="views"><i class="glyphicon glyphicon-eye-open"></i> {{ $v['view'] }}</span>
                        </p>
                        <p class="note">{{ $v['description'] }}</p>
                    </article>
                @endforeach

                @include('home.common.paging', ['data' => $results['book_update']])
            </div>
        </div>
        {{--<div class="tlinks">Collect from <a href="http://www.cssmoban.com/">企业网站模板</a></div>--}}
        <aside class="sidebar">
            <div class="fixed">
                <div class="widget widget-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#notice" aria-controls="notice" role="tab" data-toggle="tab">
                                版权所属
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#contact" aria-controls="contact" role="tab" data-toggle="tab">
                                联系站长
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane contact active" id="notice">
                            <h2>
                                <span id="sitetime">
                                    本站所有小说为转载作品，所有章节均由网友上传，转载至本站只是为了宣传本书让更多读者欣赏。
                                </span>
                            </h2>
                        </div>
                        <div role="tabpanel" class="tab-pane contact" id="contact">
                            <h2>
                                QQ:
                                <a href="#" target="_blank" data-toggle="tooltip" rel="nofollow" data-placement="bottom" data-original-title="1174955828" draggable="false">1174955828</a>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="widget widget_search">
                    <form class="navbar-form" action="{{ route('index', ['keyword' => request()->get('keyword')]) }}" method="get">
                        <div class="input-group">
                            <input type="text" name="keyword" value="{{ request()->get('keyword') }}" class="form-control" size="35" placeholder="请输入关键字" maxlength="15" autocomplete="off">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-search" type="submit">搜索</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="widget widget_hot">
                <h3>点击排行榜</h3>
                <ul>
                    @foreach($results['book_popular']['list'] as $v)
                        <li>
                            <a href="{{ route('chapter-list', ['unique_code' => $v['unique_code']]) }}" target="_blank" title="{{ $v['title'] }}">
                            <span class="thumbnail">
                                <img class="thumb" src="{{ $v['image_local_url'] }}" alt="{{ $v['title'] }}" style="display: block;">
                            </span>
                                <span class="text">{{ $v['title'] }}</span>
                                <span class="muted"><i class="glyphicon glyphicon-time"></i>
                                    {{ $v['last_update'] }}
                            </span>
                                <span class="muted"><i class="glyphicon glyphicon-eye-open"></i> {{ $v['view'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @include('home.common.friend_link')
        </aside>
    </section>
    @include('home.common.footer')
@endsection


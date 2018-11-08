@extends('home.common.base')

@section('content')
    @include('home.common.header')
    <section class="container">
        <div class="content-wrap">
            <div class="content">
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
        <aside class="sidebar">
            <div class="fixed">
                <div class="widget widget_search">
                    <form class="navbar-form" action="{{ route('article-index', ['category_id' => request()->category_id, 'keyword' => request()->get('keyword')])}}" method="get">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" size="35" placeholder="请输入关键字"
                                   maxlength="15" value="{{ request()->get('keyword') }}" autocomplete="off">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-search" name="search" type="submit">搜索</button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="widget widget_sentence">
                    <h3>标签云</h3>
                    <div class="widget-sentence-content">
                        <ul class="plinks ptags">
                            <li>
                                <a href="#list/67/" title="移动统计" draggable="false">移动统计 <span class="badge">1</span></a>
                            </li>
                            <li>
                                <a href="#list/256/" title="404" draggable="false">404 <span class="badge">1</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="widget widget_hot">
                <h3>点击排行榜</h3>
                <ul>
                    @foreach($results['book_update']['list'] as $v)
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
            <div class="widget widget_sentence">
                <a href="#" target="_blank" rel="nofollow">
                    <img style="width: 100%" src="{{ asset('/static/images/ad.jpg') }}" alt="">
                </a>
            </div>
            <div class="widget widget_sentence">
                <a href="#" target="_blank" rel="nofollow">
                    <img style="width: 100%" src="{{ asset('/static/images/201610241224221511.jpg') }}">
                </a>
            </div>
        </aside>
    </section>
    @include('home.common.footer')
@endsection


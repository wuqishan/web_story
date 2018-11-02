@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 《{{ $results['book']['title'] }}》 章节列表</h1>
                <p class="margin-top-8">
                    作者：{{ $results['book']['author'] }}&nbsp;&nbsp;&nbsp;&nbsp;
                    最近更新时间：{{ $results['book']['last_update'] }}
                </p>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">章节管理</li>
                <li class="breadcrumb-item active"><a href="#">章节列表</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form class="row" id="search-form" action="{{ route('admin.chapter.index', ['book_unique_code' => $results['book']['unique_code']]) }}" method="get">
                            <div class="form-group col-md-2">
                                <input class="form-control" autocomplete="off" type="text" name="title" value="{{ request()->get('title') }}" placeholder="标题">
                            </div>
                            <div class="form-group col-md-3">
                                <input class="form-control data-range" autocomplete="off" type="text" name="gte_number_of_words" value="{{ request()->get('gte_number_of_words') }}" placeholder="最小字数">
                                -
                                <input class="form-control data-range" autocomplete="off" type="text" name="lte_number_of_words" value="{{ request()->get('lte_number_of_words') }}" placeholder="最大字数">
                            </div>
                            <div class="form-group col-md-5">
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-info pull-right" href="javascript:$('#search-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-secondary pull-right" href="{{ route('admin.chapter.index', ['book_unique_code' => $results['book']['unique_code']]) }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>重置</a>
                            </div>
                            <input type="hidden" name="length" value="{{ request()->get('length') }}">
                        </form>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>标题</th>
                                <th>点击数</th>
                                <th>本章节字数</th>
                                <th>排序</th>
                                <th>源网站</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($results['data']['list']))
                                    @foreach($results['data']['list'] as $v)
                                        <tr>
                                            <td>{{ $v['title'] }}</td>
                                            <td>{{ $v['view'] }}</td>
                                            <td>{{ $v['number_of_words'] }}</td>
                                            <td>{{ $v['orderby'] }}</td>
                                            <td>
                                                <a target="_blank" href="{{ $v['url'] }}">源网站</a>
                                            </td>
                                            <td width="120">
                                                <a href="{{ route('admin.content.detail', ['content_id' => $v['id'], 'category_id' => $v['category_id']]) }}"><i class="fa fa-clone" aria-hidden="true"></i> 详细内容</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @include('admin.common.paging')
                </div>
            </div>
        </div>
    </main>
@endsection

@section('otherStaticSecond')
    <script type="text/javascript">

    </script>
@endsection
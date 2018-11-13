@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 书本列表</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">书本管理</li>
                <li class="breadcrumb-item active"><a href="#">书本列表</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form class="row" id="search-form" action="{{ route('admin.book.index') }}" method="get">
                            <div class="form-group col-md-2">
                                <input class="form-control" autocomplete="off" type="text" name="title" value="{{ request()->get('title') }}" placeholder="标题">
                            </div>
                            <div class="form-group col-md-2">
                                <select class="form-control" name="category_id">
                                    <option value="">选择书本分类</option>
                                    <option @if(request()->get('category_id') == 1) selected @endif value="1">玄幻奇幻</option>
                                    <option @if(request()->get('category_id') == 2) selected @endif value="2">武侠仙侠</option>
                                    <option @if(request()->get('category_id') == 3) selected @endif value="3">都市言情</option>
                                    <option @if(request()->get('category_id') == 4) selected @endif value="4">历史军事</option>
                                    <option @if(request()->get('category_id') == 5) selected @endif value="5">科幻灵异</option>
                                    <option @if(request()->get('category_id') == 6) selected @endif value="6">网游竞技</option>
                                    <option @if(request()->get('category_id') == 7) selected @endif value="7">女频频道</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <select class="form-control" name="finished">
                                    <option value="">选择完本状态</option>
                                    <option @if(request()->get('finished') == '0') selected @endif value="0">未完本</option>
                                    <option @if(request()->get('finished') == '1') selected @endif value="1">完本</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <input class="form-control data-range" autocomplete="off" type="text" name="last_update_start" id="last_update_start" value="{{ request()->get('last_update_start') }}" placeholder="最近更新日期">
                                -
                                <input class="form-control data-range" autocomplete="off" type="text" name="last_update_end" id="last_update_end" value="{{ request()->get('last_update_end') }}" placeholder="最近更新日期">
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-info pull-right" href="javascript:$('#search-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-secondary pull-right" href="{{ route('admin.book.index') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>重置</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-success pull-right" href="{{ route('admin.book.create') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>新增</a>
                            </div>
                            <input type="hidden" name="length" value="{{ request()->get('length') }}">
                        </form>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>标题</th>
                                <th>作者</th>
                                <th>分类</th>
                                <th width="165">最近更新日期</th>
                                <th width="70">点击数</th>
                                <th width="55">完本</th>
                                <th width="70">源网站</th>
                                <th width="165">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($results['data']['list']))
                                    @foreach($results['data']['list'] as $v)
                                        <tr>
                                            <td>{{ $v['title'] }}</td>
                                            <td>{{ $v['author'] }}</td>
                                            <td>{{ \App\Models\Category::categoryMap($v['category_id']) }}</td>
                                            <td>{{ $v['last_update'] }}</td>
                                            <td>{{ $v['view'] }}</td>
                                            <td>
                                                <div class="toggle">
                                                    <label>
                                                        <input class="finished-toggle" data-book-id="{{ $v['id'] }}" type="checkbox" @if($v['finished'] == 1) checked @endif><span class="button-indecator"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <a target="_blank" href="{{ $v['url'] }}">源网站</a>
                                            </td>
                                            <td>
                                                <a target="_blank" href="{{ route('admin.chapter.index', ['book_unique_code' => $v['unique_code']]) }}"><i class="fa fa-clone" aria-hidden="true"></i> 章节列表</a>
                                                &nbsp;&nbsp;
                                                <a href="{{ route('admin.book.edit', ['book_id' => $v['id']]) }}"><i class="fa fa fa-edit" aria-hidden="true"></i> 编辑</a>
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
        $(function () {
            $('#last_update_start').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                language: 'zh-CN'
            });
            $('#last_update_end').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                language: 'zh-CN'
            });

            $('.finished-toggle').change(function () {
                var book_id = $(this).attr('data-book-id');
                var finished = 0;
                if ($(this).prop('checked')) {
                    finished = 1;
                }
                var data = {'book_id': book_id, 'finished': finished, '_token': '{{ csrf_token() }}'};
                $.post('{{ route('admin.book.update.finished') }}', data, function (results) {
                    if (results.status) {
                        layer.msg('更新成功!');
                    }
                }, 'json');
            });
        });
    </script>
@endsection
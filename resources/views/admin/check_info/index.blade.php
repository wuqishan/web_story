@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 异常数据列表</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">异常数据管理</li>
                <li class="breadcrumb-item active"><a href="#">异常数据列表</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form class="row" id="search-form" action="{{ route('admin.check_info.index') }}" method="get">
                            <div class="form-group col-md-2">
                                <input class="form-control" autocomplete="off" type="text" name="book_title" value="{{ request()->get('book_title') }}" placeholder="标题">
                            </div>
                            <div class="form-group col-md-2">
                                <select class="form-control" name="book_category_id">
                                    <option value="">选择书本分类</option>
                                    <option @if(request()->get('book_category_id') == 1) selected @endif value="1">玄幻奇幻</option>
                                    <option @if(request()->get('book_category_id') == 2) selected @endif value="2">武侠仙侠</option>
                                    <option @if(request()->get('book_category_id') == 3) selected @endif value="3">都市言情</option>
                                    <option @if(request()->get('book_category_id') == 4) selected @endif value="4">历史军事</option>
                                    <option @if(request()->get('book_category_id') == 5) selected @endif value="5">科幻灵异</option>
                                    <option @if(request()->get('book_category_id') == 6) selected @endif value="6">网游竞技</option>
                                    <option @if(request()->get('book_category_id') == 7) selected @endif value="7">女频频道</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <select class="form-control" name="status">
                                    <option value="">选择状态</option>
                                    <option @if(request()->get('status') == 1) selected @endif value="1">未解决</option>
                                    <option @if(request()->get('status') == 2) selected @endif value="2">已解决</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-info pull-right" href="javascript:$('#search-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-secondary pull-right" href="{{ route('admin.check_info.index') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>重置</a>
                            </div>
                            <input type="hidden" name="length" value="{{ request()->get('length') }}">
                        </form>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>书本标题</th>
                                <th>分类</th>
                                <th>信息</th>
                                <th>状态</th>
                                <th>时间</th>
                                <th width="168">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($results['data']['list']))
                                    @foreach($results['data']['list'] as $v)
                                        <tr>
                                            <td>{{ $v['book_title'] }}</td>
                                            <td>{{ $v['book_category_id'] }}</td>
                                            <td>{{ $v['message'] }}</td>
                                            <td>
                                                @if($v['status'] == 1)
                                                    未解决
                                                @elseif($v['status'] == 2)
                                                    已解决
                                                @else
                                                    状态异常
                                                @endif
                                            </td>
                                            <td>{{ $v['created_at'] }}</td>
                                            <td>
                                                <a href="{{ route('admin.chapter.index', ['book_unique_code' => $v['book_unique_code']]) }}"><i class="fa fa-clone" aria-hidden="true"></i> 章节列表</a>
                                                @if($v['status'] == 1)
                                                    &nbsp;|&nbsp;
                                                    <a href="javascript:update_record('{{ route('admin.check_info.update', ['id' => $v['id'], 'status' => 2]) }}', '{{ route('admin.check_info.index') }}')"><i class="fa fa-check" aria-hidden="true"></i> 解决</a>
                                                @endif
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
        function update_record(url, gotoUrl)
        {
            layer.confirm('更新该条记录为已解决？', {
                skin: 'layui-layer-molv',
                btn: ['确定','取消']
            }, function() {
                $.ajax({
                    'url': url,
                    'type': 'post',
                    'data': {'_token': '{{ csrf_token() }}'},
                    'dataType': 'json',
                    'success': function (results) {
                        if (results.status) {
                            layer.msg('更新成功！', {'anim': -1, 'time': 4,}, function () {
                                location.href = gotoUrl;
                            });
                        }
                    }
                });
            });
        }
    </script>
@endsection
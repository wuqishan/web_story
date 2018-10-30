@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 章节列表</h1>
                <p>仓库中所有商品种类管理</p>
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
                            <div class="form-group col-md-4">
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-info pull-right" href="javascript:$('#search-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-secondary pull-right" href="{{ route('admin.book.index') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>重置</a>
                            </div>
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
                                                <a href=""><i class="fa fa-clone" aria-hidden="true"></i> 详细内容</a>
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

        function del_record(id)
        {
            layer.confirm('确定删除该条记录？', {
                skin: 'layui-layer-molv',
                btn: ['确定','取消']
            }, function() {
                $.ajax({
                    'url': "/admin/goods/" + id,
                    'type': 'post',
                    'data': {'_method': 'DELETE', '_token': '{{ csrf_token() }}'},
                    'dataType': 'json',
                    'success': function (results) {
                        if (results.status) {
                            layer.msg('删除成功！', {'anim': -1, 'time': 4,}, function () {
                                location.href = '{{ route('admin.book.index') }}'
                            });
                        }
                    }
                });
            });
        }
    </script>
@endsection
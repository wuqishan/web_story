@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i>网站文章列表</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">网站文章管理</li>
                <li class="breadcrumb-item active"><a href="#">网站文章列表</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form class="row" action="{{ route('admin.common_article.index') }}" method="get" id="search-form">
                            <div class="form-group col-md-3">
                                <input class="form-control" type="text" name="name" value="{{ request()->get('name') }}" placeholder="名称">
                            </div>
                            <div class="form-group col-md-6">
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-info pull-right" href="javascript:$('#search-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-secondary pull-right" href="{{ route('admin.common_article.index') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>重置</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-success pull-right" href="{{ route('admin.common_article.create') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>新增</a>
                            </div>
                        </form>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>标题</th>
                                <th>排序</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($results['data']['list'] as $v)
                                    <tr>
                                        <td>{{ $v['title'] }}</td>
                                        <td>{{ $v['orderby'] }}</td>
                                        <td width="130">
                                            <a href="{{ route('admin.common_article.edit', ['category_id' => $v['id']]) }}"><i class="fa fa-edit" aria-hidden="true"></i> 编辑</a>
                                            &nbsp;&nbsp;
                                            <a href="javascript:del_record('{{ route('admin.common_article.destroy', ['category_id' => $v['id']]) }}', '{{ route('admin.common_article.index') }}');"><i class="fa fa-trash-o" aria-hidden="true"></i> 删除</a>
                                        </td>
                                    </tr>
                                @endforeach
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
        function del_record(url, gotoUrl)
        {
            layer.confirm('确定删除该条记录？', {
                skin: 'layui-layer-molv',
                btn: ['确定','取消']
            }, function() {
                $.ajax({
                    'url': url,
                    'type': 'post',
                    'data': {'_method': 'DELETE', '_token': '{{ csrf_token() }}'},
                    'dataType': 'json',
                    'success': function (results) {
                        if (results.status) {
                            layer.msg('删除成功！', {'anim': -1, 'time': 4,}, function () {
                                location.href = gotoUrl;
                            });
                        }
                    }
                });
            });
        }
    </script>
@endsection
@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 作者列表</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">作者管理</li>
                <li class="breadcrumb-item active"><a href="#">作者列表</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form class="row" action="{{ route('admin.author.index') }}" method="get" id="search-from">
                            <div class="form-group col-md-3">
                                <input class="form-control" type="text" name="name" value="{{ request()->get('name') }}" placeholder="名称">
                            </div>
                            <div class="form-group col-md-7">
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-info pull-right" href="javascript:$('#search-from').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-secondary pull-right" href="{{ route('admin.author.index') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>重置</a>
                            </div>
                        </form>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>名称</th>
                                <th>作品数量</th>
                                <th width="230">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($results['data']['list'] as $v)
                                    <tr>
                                        <td>{{ $v['name'] }}</td>
                                        <td>{{ $v['book_number'] }}</td>
                                        <td>
                                            <a target="_blank" href="{{ route('admin.book.index', ['author_id' => $v['id']]) }}"><i class="fa fa-book" aria-hidden="true"></i> 对应书本</a>
                                            &nbsp;|&nbsp;
                                            <a href="{{ route('admin.author.edit', ['author_id' => $v['id']]) }}"><i class="fa fa-edit" aria-hidden="true"></i> 编辑</a>
                                            &nbsp;|&nbsp;
                                            <a href="javascript:del_record('{{ route('admin.author.destroy', ['author_id' => $v['id']]) }}', '{{ route('admin.author.index') }}');"><i class="fa fa-trash-o" aria-hidden="true"></i> 删除</a>
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
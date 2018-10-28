@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 分类列表</h1>
                <p>Table to display analytical data effectively</p>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">分类管理</li>
                <li class="breadcrumb-item active"><a href="#">分类列表</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form class="row">
                            <div class="form-group col-md-3">
                                <input class="form-control" type="text" name="title" placeholder="请输入">
                            </div>
                            <div class="form-group col-md-7">
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-info pull-right" href="{{ route('admin::category.create') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-success pull-right" href="{{ route('admin::category.create') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>新增</a>
                            </div>
                        </form>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>名称</th>
                                <th>等级</th>
                                <th>排序</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($results['data']['list'] as $v)
                                    <tr class="parent_{{ $v['parent_id'] }}">
                                        <td>┏━━━{{ $v['html'] }} {{ $v['title'] }}</td>
                                        <td>{{ $v['level'] }}</td>
                                        <td>{{ $v['order'] }}</td>
                                        <td width="120">
                                            {!! \App\Helper\OptionBtnHelper::get('edit', route('admin::category.edit', ['category' => $v['id']])) !!}
                                            {!! \App\Helper\OptionBtnHelper::get('del', 'del_record(\''. $v['id'] .'\')') !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                    'url': "/admin/category/" + id,
                    'type': 'post',
                    'data': {'_method': 'DELETE', '_token': '{{ csrf_token() }}'},
                    'dataType': 'json',
                    'success': function (results) {
                        if (results.status) {
                            layer.msg('删除成功！', {'anim': -1, 'time': 4,}, function () {
                                location.href = '{{ route('admin::category.index') }}'
                            });
                        } else {
                            layer.msg('只能从最低层分类开始删除！');
                        }
                    }
                });
            });
        }
    </script>
@endsection
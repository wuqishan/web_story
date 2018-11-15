@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 用户列表</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">用户管理</li>
                <li class="breadcrumb-item active"><a href="#">用户列表</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form class="row" action="{{ route('admin.user.index') }}" method="get" id="search-from">
                            <div class="form-group col-md-2">
                                <input class="form-control" type="text" name="username" value="{{ request()->get('username') }}" placeholder="用户名 或 昵称 或 邮箱">
                            </div>
                            <div class="form-group col-md-2">
                                <select name="status" class="form-control">
                                    <option>请选择</option>
                                    <option @if(request()->get('status') == 1) selected @endif value="1">开启</option>
                                    <option @if(request()->get('status') == 2) selected @endif value="2">禁用</option>
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-info pull-right" href="javascript:$('#search-from').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-secondary pull-right" href="{{ route('admin.user.index') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>重置</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-success pull-right" href="{{ route('admin.user.create') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>新增</a>
                            </div>
                        </form>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>用户名</th>
                                <th>昵称</th>
                                <th>邮箱</th>
                                <th>状态</th>
                                <th>最近登录时间</th>
                                <th>最近登录IP</th>
                                <th>创建时间</th>
                                <th width="140">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($results['data']['list'] as $v)
                                    <tr>
                                        <td>{{ $v['username'] }}</td>
                                        <td>{{ $v['nickname'] }}</td>
                                        <td>{{ $v['email'] }}</td>
                                        <td>@if($v['status'] == 1) 启用 @else 禁用 @endif</td>
                                        <td>{{ $v['latest_login_time'] }}</td>
                                        <td>{{ $v['latest_login_ip'] }}</td>
                                        <td>{{ $v['created_at'] }}</td>
                                        <td>
                                            <a href="{{ route('admin.user.edit', ['user_id' => $v['id']]) }}"><i class="fa fa-edit" aria-hidden="true"></i> 编辑</a>
                                            &nbsp;|&nbsp;
                                            <a href="javascript:del_record('{{ route('admin.user.destroy', ['user_id' => $v['id']]) }}', '{{ route('admin.user.index') }}');"><i class="fa fa-trash-o" aria-hidden="true"></i> 删除</a>
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
@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 书本导入日志列表</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">书本导入日志管理</li>
                <li class="breadcrumb-item active"><a href="#">书本导入日志列表</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form class="row" action="{{ route('admin.import_log.index') }}" method="get" id="search-from">
                            <div class="form-group col-md-3">
                                <input class="form-control" type="text" name="name" value="{{ request()->get('name') }}" placeholder="名称">
                            </div>
                            <div class="form-group col-md-6">
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-info pull-right" href="javascript:$('#search-from').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-secondary pull-right" href="{{ route('admin.import_log.index') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>重置</a>
                            </div>
                        </form>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>导入数量</th>
                                <th>导入类型</th>
                                <th>导入结束时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($results['data']['list'] as $v)
                                    <tr>
                                        <td>{{ $v['number'] }}</td>
                                        <td>{{ \App\Models\ImportLog::$typeMap[$v['type']] }}</td>
                                        <td>{{ $v['created_at'] }}</td>
                                        <td width="130">
                                            <a href="javascript:show_detail('{{ route('admin.import_log.show', ['import_log_id' => $v['id']]) }}', '{{ $v['type'] }}', '{{ $v['created_at'] }}')"><i class="fa fa-clone" aria-hidden="true"></i> 详细</a>
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
        function show_detail(url, import_type, created_at)
        {
            layer.open({
                title: (import_type === '1' ? '书本导入' : '章节') + "导入信息, 时间: " + created_at,
                type: 2,
                area: ['60%', '70%'],
                fixed: false, //不固定
                shadeClose: true,
                maxmin: true,
                resize:true,
                content: url
            });
        }
    </script>
@endsection
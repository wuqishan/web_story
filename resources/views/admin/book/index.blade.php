@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 商品列表</h1>
                <p>仓库中所有商品种类管理</p>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">商品管理</li>
                <li class="breadcrumb-item active"><a href="#">商品列表</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form class="row" id="search-form" action="{{ route('admin::goods.index') }}" method="get">
                            <div class="form-group col-md-2">
                                <input class="form-control" autocomplete="off" type="text" name="keyword" value="{{ request()->get('keyword') }}" placeholder="标题">
                            </div>
                            <div class="form-group col-md-2">
                                <select class="form-control" name="status">
                                    <option value="">选择状态</option>
                                    <option @if(request()->get('status') == 1) selected @endif value="1">上架</option>
                                    <option @if(request()->get('status') == 2) selected @endif value="2">下架</option>
                                </select>
                            </div>
                            <div class="form-group col-md-5"></div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-info pull-right" href="javascript:$('#search-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-secondary pull-right" href="{{ route('admin::goods.index') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>重置</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-success pull-right" href="{{ route('admin::goods.create') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>新增</a>
                            </div>
                        </form>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>名称</th>
                                <th>数量单位</th>
                                <th>状态</th>
                                <th>进货总数量</th>
                                <th>出售总数量</th>
                                <th>库存</th>
                                <th>新增日期</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($results['data']['list']))
                                    @foreach($results['data']['list'] as $v)
                                        <tr>
                                            <td>{{ $v['title'] }}</td>
                                            <td>{{ $v['unit'] }}</td>
                                            <td>{{ $v['status'] == 1 ? '上架' : '下架' }}</td>
                                            <td>{{ $v['import_number'] }}</td>
                                            <td>{{ $v['export_number'] }}</td>
                                            <td>{{ $v['stock'] }}</td>
                                            <td>{{ $v['created_at'] }}</td>
                                            <td width="120">
                                                {!! \App\Helper\OptionBtnHelper::get('edit', route('admin::goods.edit', ['article' => $v['id']])) !!}
                                                {!! \App\Helper\OptionBtnHelper::get('del', 'del_record(\''. $v['id'] .'\')') !!}
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
                                location.href = '{{ route('admin::goods.index') }}'
                            });
                        }
                    }
                });
            });
        }
    </script>
@endsection
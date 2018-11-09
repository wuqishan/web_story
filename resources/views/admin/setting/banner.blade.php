@extends('admin.common.base')
@section('otherStaticFirst')
    <link rel="stylesheet" type="text/css" href="{{ asset('/static/admin/css/upload.css') }}">
@endsection
@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-plus-square"></i> 首页Banner管理</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">Banner管理</li>
                <li class="breadcrumb-item"><a href="#">Banner管理</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Banner 图片</th>
                                <th>显示排序</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results['data']['list'] as $v)
                                <tr>
                                    <td><a href="{{ $v['value'] }}" target="_blank">{{ $v['value'] }}</a></td>
                                    <td>{{ $v['orderby'] }}</td>
                                    <td width="130">
                                        <a href="javascript:edit_record('{{ $v['id'] }}', '{{ $v['orderby'] }}')"><i class="fa fa-edit" aria-hidden="true"></i> 编辑</a>
                                        &nbsp;&nbsp;
                                        <a href="javascript:del_record('{{ route('admin.setting.delete', ['id' => $v['id']]) }}', '{{ route('admin.setting.banner') }}');"><i class="fa fa-trash-o" aria-hidden="true"></i> 删除</a>
                                    </td>
                                </tr>
                            @endforeach
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tile-body col-lg-6">
                        <form id="form-data" class="row">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="0">
                            <input type="hidden" name="name" value="banner">
                            <div class="form-group col-md-12">
                                <label>Banner 图片 :</label>
                                <input class="form-control" type="file" name="value" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>显示排序 :</label>
                                <input class="form-control" type="text" name="orderby" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                        </form>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary submit" type="button">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('otherStaticSecond')
    <!-- Data table plugin-->
    <script type="text/javascript">
        $(function () {
            var sub_opt = {
                'formSelector': '#form-data',
                'url': '{{ route("admin.setting.banner.post") }}',
                'goTo': '{{ route('admin.setting.banner') }}'
            };
            $('.submit').click(function () {
                $.sys_submit(sub_opt);
            });
        });

        function del_record(url, gotoUrl)
        {
            layer.confirm('确定删除该条记录？', {
                skin: 'layui-layer-molv',
                btn: ['确定','取消']
            }, function() {
                $.ajax({
                    'url': url,
                    'type': 'post',
                    'data': {'_method': 'DELETE', '_token': '{{ csrf_token() }}', 'del_image': true},
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

        function edit_record(id, orderby) {
            $('input[name="id"]').val(id);
            $('input[name="orderby"]').val(orderby);
            $('input[name="value"]').attr('disabled', true);
        }
    </script>
@endsection
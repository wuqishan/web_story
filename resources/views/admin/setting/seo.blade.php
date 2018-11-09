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
                <h1><i class="fa fa-plus-square"></i> SEO 管理</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">SEO 管理</li>
                <li class="breadcrumb-item"><a href="#">SEO 管理</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>标签</th>
                                <th>内容</th>
                                <th width="80">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results['data']['list'] as $v)
                                <tr>
                                    <td>{{ $v['name'] }}</td>
                                    <td>{{ $v['value'] }}</td>
                                    <td >
                                        <a href="javascript:edit_record('{{ $v['id'] }}', '{{ $v['name'] }}', '{{ $v['value'] }}')"><i class="fa fa-edit" aria-hidden="true"></i> 编辑</a>
                                    </td>
                                </tr>
                            @endforeach
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tile-body">
                        <form id="form-data" class="row">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="0">
                            <input type="hidden" name="name" value="">
                            <div class="form-group col-md-12">
                                <label class="show-label">选择编辑：</label>
                                <textarea class="form-control" placeholder="请输入" name="value"></textarea>
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
                'url': '{{ route("admin.setting.seo.post") }}',
                'goTo': '{{ route('admin.setting.seo') }}'
            };
            $('.submit').click(function () {
                $.sys_submit(sub_opt);
            });
        });

        function edit_record(id, name, value) {
            $('input[name="id"]').val(id);
            $('input[name="name"]').val(name);
            $('textarea[name="value"]').val(value);
            $('.show-label').text(name + ' 新内容：');
        }
    </script>
@endsection
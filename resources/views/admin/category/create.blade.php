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
                <h1><i class="fa fa-plus-square"></i> 添加分类</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">分类管理</li>
                <li class="breadcrumb-item"><a href="#">列表</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form id="form-data" class="row">
                            {{ csrf_field() }}
                            <input type="hidden" name="level" value="1">

                            <div class="form-group col-md-6">
                                <label>分类名称 :</label>
                                <input class="form-control" type="text" name="title" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>父级分类 :</label>
                                <select class="form-control" name="parent_id">
                                    <option value="0" level="1">━━━ 顶级分类</option>
                                    @foreach($results['form']['parent'] as $v)
                                        <option value="{{ $v['id'] }}" level="{{ $v['level'] + 1 }}">━━━━━━{{ $v['html'] }} {{ $v['title'] }}</option>
                                    @endforeach
                                </select>
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>显示顺序 :</label>
                                <input class="form-control" type="text" name="order" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6"></div>
                            <div class="form-group col-md-12">
                                <label>简述 :</label>
                                <textarea class="form-control" name="description" rows="3"></textarea>
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
    <script src="{{ asset('/static/admin/js/plugins/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('/static/admin/js/plugins/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('/static/admin/js/plugins/jquery.fileupload.js') }}"></script>
    <!-- Data table plugin-->
    <script type="text/javascript">
        $(function () {
            var sub_opt = {
                'formSelector': '#form-data',
                'url': '{{ route("admin::category.store") }}',
                'goTo': '{{ route('admin::category.index') }}'
            };
            $('.submit').click(function () {
                $.sys_submit(sub_opt);
            });
            $('#form-data select[name=parent_id]').change(function(){
                var level = $(this).find('option:selected').attr('level');
                $('#form-data input[name=level]').val(level);
            });
        });
    </script>
@endsection
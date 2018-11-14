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
                <h1><i class="fa fa-plus-square"></i> 添加用户</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">用户管理</li>
                <li class="breadcrumb-item"><a href="#">用户添加</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form id="form-data" class="row">
                            {{ csrf_field() }}
                            <div class="form-group col-md-6">
                                <label>用户名 :</label>
                                <input class="form-control" type="text" name="username" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>昵称 :</label>
                                <input class="form-control" type="text" name="nickname" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>密码 :</label>
                                <input class="form-control" type="text" name="password" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>确认密码 :</label>
                                <input class="form-control" type="text" name="password_confirmation" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>邮箱 :</label>
                                <input class="form-control" type="text" name="email" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>状态 :</label>
                                <div class="toggle-flip">
                                    <label>
                                        <input type="checkbox" checked class="switch_status"><span class="flip-indecator" data-toggle-on="开启" data-toggle-off="禁用"></span>
                                        <input type="hidden" class="switch_status_val" name="status" value="1">
                                    </label>
                                </div>
                                <div class="form-control-feedback"></div>
                            </div>
                        </form>
                    </div>
                    <div class="tile-footer">
                        <div class="row d-print-none mt-2">
                            <div class="col-12 text-right"><a class="btn btn-primary submit" href="javascript:void(0);" target="_blank">提 交</a></div>
                        </div>
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
                'url': '{{ route("admin.user.store") }}',
                'goTo': '{{ route('admin.user.index') }}'
            };
            $('.submit').click(function () {
                $.sys_submit(sub_opt);
            });

            // 禁用与否
            $('.switch_status').change(function () {
                if ($(this).prop('checked')) {
                    $('.switch_status_val').val('1');
                } else {
                    $('.switch_status_val').val('2');
                }
            });
        });
    </script>
@endsection
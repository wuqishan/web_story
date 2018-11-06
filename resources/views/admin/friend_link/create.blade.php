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
                <h1><i class="fa fa-plus-square"></i> 添加友情链接</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">友情链接管理</li>
                <li class="breadcrumb-item"><a href="#">友情链接添加</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form id="form-data" class="row">
                            {{ csrf_field() }}
                            <div class="form-group col-md-6">
                                <label>标题 :</label>
                                <input class="form-control" type="text" name="title" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>链接 :</label>
                                <input class="form-control" type="text" name="link" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>状态 :</label>
                                <select class="form-control" name="deleted">
                                    <option>请选择</option>
                                    <option value="1">正常</option>
                                    <option value="2">删除</option>
                                </select>
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>排序 :</label>
                                <input class="form-control" type="text" name="orderby" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>简介 :</label>
                                <textarea name="description" class="form-control"></textarea>
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
                'url': '{{ route("admin.friend_link.store") }}',
                'goTo': '{{ route('admin.friend_link.index') }}'
            };
            $('.submit').click(function () {
                $.sys_submit(sub_opt);
            });
        });
    </script>
@endsection
@extends('admin.common.base')
@section('otherStaticFirst')
    {{-- 加载编辑器 --}}
    <script type="text/javascript" charset="utf-8" src="{{ asset('/static/admin/editor/ueditor.config.js') }}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('/static/admin/editor/ueditor.all.js') }}"> </script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('/static/admin/editor/lang/zh-cn/zh-cn.js') }}"></script>
@endsection
@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-plus-square"></i> 编辑网站文章</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">网站文章管理</li>
                <li class="breadcrumb-item"><a href="#">网站文章编辑</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form id="form-data" class="row">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group col-md-6">
                                <label>标题 :</label>
                                <input class="form-control" type="text" value="{{ $results['detail']['title'] }}" name="title" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>排序 :</label>
                                <input class="form-control" type="text" value="{{ $results['detail']['orderby'] }}" name="orderby" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>内容 :</label>
                                <textarea id="content" name="content" style="width:100%;height:200px;">{!! $results['detail']['content'] !!}</textarea>
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
    <script src="{{ asset('/static/admin/js/plugins/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('/static/admin/js/plugins/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('/static/admin/js/plugins/jquery.fileupload.js') }}"></script>
    <!-- Data table plugin-->
    <script type="text/javascript">

        var ue = UE.getEditor('content');

        $(function () {
            var sub_opt = {
                'formSelector': '#form-data',
                'url': '{{ route("admin.common_article.update", ['common_article_id' => request()->common_article_id]) }}',
                'goTo': '{{ route('admin.common_article.index') }}'
            };
            $('.submit').click(function () {
                $.sys_submit(sub_opt);
            });
        });
    </script>
@endsection
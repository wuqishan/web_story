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
                <h1><i class="fa fa-plus-square"></i> 小说编辑</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">小说管理</li>
                <li class="breadcrumb-item"><a href="#">编辑</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form id="form-data" class="row">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="form-group col-md-6">
                                <label>小说书名 :</label>
                                <input class="form-control" disabled value="{{ $results['detail']['title'] }}" type="text" name="title" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>本书唯一码 :</label>
                                <input class="form-control" disabled value="{{ $results['detail']['unique_code'] }}" type="text" name="unique_code" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>作者 :</label>
                                <input class="form-control" disabled value="{{ $results['detail']['author'] }}" type="text" name="author" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>最近更新时间 :</label>
                                <input class="form-control" disabled value="{{ $results['detail']['last_update'] }}" type="text" name="last_update" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>本地图片 :</label>
                                <input class="form-control" disabled value="{{ $results['detail']['image_local_url'] }}" type="text" name="image_local_url" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>远程图片 :</label>
                                <input class="form-control" disabled value="{{ $results['detail']['image_origin_url'] }}" type="text" name="image_origin_url" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>点击数量 :</label>
                                <input class="form-control" value="{{ $results['detail']['view'] }}" type="text" name="view" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>最新章节唯一码 :</label>
                                <input class="form-control" value="{{ $results['detail']['newest_chapter'] }}" type="text" name="newest_chapter" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                            </div>
                            <div class="form-group col-md-12">
                                <label>本书是否完本 :</label>
                                <div class="animated-radio-button">
                                    <label>
                                        <input type="radio" @if($results['detail']['finished'] == 0) checked @endif name="finished" value="0">
                                        <span class="label-text">未完本</span>
                                    </label>
                                </div>
                                <div class="animated-radio-button">
                                    <label>
                                        <input type="radio" @if($results['detail']['finished'] == 1) checked @endif name="finished" value="1">
                                        <span class="label-text">已完本</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label>简述 :</label>
                                <textarea class="form-control" disabled name="description" rows="3">{{ $results['detail']['description'] }}</textarea>
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
                'url': '{{ route("admin.book.update", ['book_id' => request()->book_id]) }}',
                'goTo': '{{ route('admin.book.index') }}'
            };
            $('.submit').click(function () {
                $.sys_submit(sub_opt);
            });
        });
    </script>
@endsection
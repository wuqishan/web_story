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
                <h1><i class="fa fa-plus-square"></i> 商品文章</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">商品管理</li>
                <li class="breadcrumb-item"><a href="#">添加</a></li>
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
                                <label>商品名称 :</label>
                                <input class="form-control" type="text" name="title" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>商品数量单位 :</label>
                                <input class="form-control" type="text" name="unit" placeholder="请输入">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>商品状态 :</label>
                                <select class="form-control" name="status">
                                    <option value="">请选择</option>
                                    <option value="1">上架</option>
                                    <option value="2">下架</option>
                                </select>
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group col-md-6"></div>
                            <div class="form-group col-md-12 upload_area"></div>
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
            var option = {
                'url': '{{ route("admin::upload") }}',
                'defaultImg': "{{ asset('/static/admin/images/upload.png') }}",
                'uploadAreaObj': $('.upload_area'),
                'formData': {'_token': '{{ csrf_token() }}', 'name': 'photo'},
                'multiple': true,
                'hiddenName': 'image_id',
                'callback': function (results) {
                    // 回调函数处理
                    let images = $('input[name="goods_images"]').val();
                    console.log(results);
                }
            };
            $.sys_upload_img(option);

            var sub_opt = {
                'formSelector': '#form-data',
                'url': '{{ route("admin::goods.store") }}',
                'goTo': '{{ route('admin::goods.index') }}'
            };
            $('.submit').click(function () {
                $.sys_submit(sub_opt);
            });
        });
    </script>
@endsection
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
                <h1><i class="fa fa-plus-square"></i> Logo管理</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">Logo管理</li>
                <li class="breadcrumb-item"><a href="#">Logo管理</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table">
                            <tr>
                                <th>Logo 图片</th>
                                <td>
                                    @if(isset($results['data']['value']))
                                        <a href="{{ $results['data']['value'] }}" target="_blank">
                                            <img src="{{ $results['data']['value'] }}" width="200px;">
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </table>
                    </div>
                    <div class="tile-body col-lg-6">
                        <form id="form-data" class="row">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="@if(isset($results['data']['id'])){{ $results['data']['id'] }}@endif">
                            <input type="hidden" name="name" value="logo">
                            <div class="form-group col-md-12">
                                <label>Logo 图片 :</label>
                                <input class="form-control" type="file" name="value" placeholder="请输入">
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
                'url': '{{ route("admin.setting.logo.post") }}',
                'goTo': '{{ route('admin.setting.logo') }}'
            };
            $('.submit').click(function () {
                $.sys_submit(sub_opt);
            });
        });
    </script>
@endsection
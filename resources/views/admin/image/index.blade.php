@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 封面图片</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">封面图片检测</li>
                <li class="breadcrumb-item active"><a href="#">封面图片检测</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form class="row" id="search-form" action="{{ route('admin.book.index') }}" method="get">
                            {{--<div class="form-group col-md-2">--}}
                                {{--<input class="form-control" autocomplete="off" type="text" name="title" value="{{ request()->get('title') }}" placeholder="标题">--}}
                            {{--</div>--}}
                            <div class="form-group col-md-8">
                            </div>
                            {{--<div class="form-group col-md-1 align-self-end">--}}
                                {{--<a class="btn btn-outline-info pull-right" href="javascript:$('#search-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>--}}
                            {{--</div>--}}
                            {{--<div class="form-group col-md-1 align-self-end">--}}
                                {{--<a class="btn btn-outline-secondary pull-right" href="{{ route('admin.book.index') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>重置</a>--}}
                            {{--</div>--}}
                            <div class="form-group col-md-3 align-self-end">
                                <a class="btn btn-outline-success pull-right" href="javascript:checkImage();"><i class="fa fa-fw fa-lg fa-check-circle"></i>检测(总数 / 异常: {{ $results['check']['book_number'] }} / {{ $results['check']['without_image_book_number'] }})</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-warning pull-right" href="javascript:updateImage(0);"><i class="fa fa-fw fa-lg fa-check-circle"></i>更新</a>
                            </div>
                        </form>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>书名</th>
                                <th>图片源URL</th>
                                <th>本地图片URL</th>
                                <th width="135">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results['check']['books'] as $v)
                                <tr>
                                    <td><a target="_blank" href="{{ $v['url'] }}">{{ $v['title'] }}</a></td>
                                    <td id="image_local_url_{{ $v['id'] }}"><a target="_blank" href="{{ $v['image_origin_url'] }}">{{ $v['image_origin_url'] }}</a></td>
                                    <td>{{ $v['image_local_url'] }}</td>
                                    <td>
                                        <a href="javascript:updateImage('{{ $v['id'] }}');"><i class="fa fa-cloud-download" aria-hidden="true"></i> 更新</a>
                                        &nbsp;|&nbsp;
                                        <a href="javascript:updateImageOriginUrl(this, '{{ $v['id'] }}', '{{ $v['image_origin_url'] }}');"><i class="fa fa-edit" aria-hidden="true"></i> 编辑源</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('otherStaticSecond')
    <script type="text/javascript">
        function checkImage()
        {
            var loadIndex = layer.load(2);
            $.post('{{ route('admin.image.check') }}', {'_token': '{{ csrf_token() }}'}, function(results) {
                if (results) {
                    layer.close(loadIndex);
                    var msg = '检测结束,结果如下：<br>' +
                        '共有书本：'+results['book_number'] + ' 本<br>'  +
                        '没有封面的书本：' + results['without_image_book_number'] + ' 本';
                    layer.alert(msg, {icon: 6});
                }
            }, 'json');
        }

        function updateImage(book_id)
        {
            var loadIndex = layer.load(2);
            $.post('{{ route('admin.image.update') }}', {'_token': '{{ csrf_token() }}', 'book_id': book_id}, function(results) {
                layer.close(loadIndex);
                if (results.update == 2) {
                    var msg = '更新结果如下：<br>' +
                        '共有书本：'+results['book_number'] + ' 本<br>'  +
                        '本次更新书本：' + results['without_image_book_number'] + ' 本';
                } else if (results.update == 1) {
                    var msg = '待更新封面的书本过多，不建议此处更新!';
                } else if (results.update == 3) {
                    var msg = '待更新封面的书本数量为 0，不做处理!';
                }
                layer.alert(msg, {icon: 6});
            }, 'json');
        }

        function updateImageOriginUrl(obj, book_id, url)
        {
            var data = {};
            data._token = '{{ csrf_token() }}';
            data.book_id = book_id;
            layer.prompt({
                value: url,
                title: '编辑源图片URL'
            }, function(val, index) {
                data.image_origin_url = val;
                $.post('{{ route('admin.image.update_image_url') }}', data, function (results) {
                    $('#image_local_url_' + book_id).find('a').attr('href', val);
                    $('#image_local_url_' + book_id).find('a').text(val);
                    layer.close(index);
                }, 'json');
            });
        }
        // https://www.xbiquge6.com/cover/84/84483/84483s.jpg
    </script>
@endsection
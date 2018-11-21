@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 异常数据列表</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">异常数据管理</li>
                <li class="breadcrumb-item active"><a href="#">异常数据列表</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form class="row" id="search-form" action="{{ route('admin.check_info.index') }}" method="get">
                            <div class="form-group col-md-2">
                                <input class="form-control" autocomplete="off" type="text" name="book_title" value="{{ request()->get('book_title') }}" placeholder="标题">
                            </div>
                            <div class="form-group col-md-2">
                                <input class="form-control" autocomplete="off" type="text" name="message" value="{{ request()->get('message') }}" placeholder="信息">
                            </div>
                            <div class="form-group col-md-2">
                                <select class="form-control" name="book_category_id">
                                    <option value="">选择书本分类</option>
                                    <option @if(request()->get('book_category_id') == 1) selected @endif value="1">玄幻奇幻</option>
                                    <option @if(request()->get('book_category_id') == 2) selected @endif value="2">武侠仙侠</option>
                                    <option @if(request()->get('book_category_id') == 3) selected @endif value="3">都市言情</option>
                                    <option @if(request()->get('book_category_id') == 4) selected @endif value="4">历史军事</option>
                                    <option @if(request()->get('book_category_id') == 5) selected @endif value="5">科幻灵异</option>
                                    <option @if(request()->get('book_category_id') == 6) selected @endif value="6">网游竞技</option>
                                    <option @if(request()->get('book_category_id') == 7) selected @endif value="7">女频频道</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <select class="form-control" name="status">
                                    <option value="">选择状态</option>
                                    <option @if(request()->get('status') == 1) selected @endif value="1">未解决</option>
                                    <option @if(request()->get('status') == 2) selected @endif value="2">已解决</option>
                                    <option @if(request()->get('status') == 3) selected @endif value="3">已忽略</option>
                                </select>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-info pull-right" href="javascript:$('#search-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-secondary pull-right" href="{{ route('admin.check_info.index') }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>重置</a>
                            </div>
                            {{--<div class="form-group col-md-1 align-self-end">--}}
                                {{--<a class="btn btn-outline-warning pull-right" href="javascript:update_record('{{ route('admin.check_info.update') }}', '{{ route('admin.check_info.index') }}');"><i class="fa fa-fw fa-lg fa-check-circle"></i>解决</a>--}}
                            {{--</div>--}}
                            {{--<div class="form-group col-md-1 align-self-end">--}}
                                {{--<a class="btn btn-outline-warning pull-right" href="javascript:del_record('{{ route('admin.check_info.delete') }}', '{{ route('admin.check_info.index') }}');"><i class="fa fa-fw fa-lg fa-trash-o"></i>删除</a>--}}
                            {{--</div>--}}

                            <div class="form-group col-md-1 align-self-end">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-danger dropdown-toggle btn-outline-warning pull-right" id="btnGroupDrop4" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-fw fa-lg fa-check-circle"></i> 操作</button>
                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="width: 80px;">
                                        <a class="dropdown-item" href="javascript:update_record('{{ route('admin.check_info.update') }}', '{{ route('admin.check_info.index') }}', 2);">解决</a>
                                        <a class="dropdown-item" href="javascript:update_record('{{ route('admin.check_info.update') }}', '{{ route('admin.check_info.index') }}', 3);">忽略</a>
                                        <a class="dropdown-item" href="javascript:del_record('{{ route('admin.check_info.delete') }}', '{{ route('admin.check_info.index') }}');">删除</a>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="length" value="{{ request()->get('length') }}">
                        </form>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>
                                    <input style="margin-left:0px;margin-top: -15px;" class="form-check-input checkbox-select-all" type="checkbox">
                                </th>
                                <th>书本标题</th>
                                <th>分类</th>
                                <th>信息</th>
                                <th>状态</th>
                                <th>时间</th>
                                <th width="200">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($results['data']['list']))

                                    @foreach($results['data']['list'] as $v)
                                        <tr class="every-record">
                                            <td>
                                                <input style="margin-left:0px;" class="form-check-input check-id" value="{{ $v['id'] }}" type="checkbox">
                                            </td>
                                            <td>{{ $v['book_title'] }}</td>
                                            <td>{{ $v['book_category_id'] }}</td>
                                            <td>{{ $v['message'] }}</td>
                                            <td>
                                                @if($v['status'] == 1)
                                                    未解决
                                                @elseif($v['status'] == 2)
                                                    已解决
                                                @elseif($v['status'] == 3)
                                                    已忽略
                                                @else
                                                    状态异常
                                                @endif
                                            </td>
                                            <td>{{ $v['created_at'] }}</td>
                                            <td>
                                                <a href="{{ route('admin.chapter.index', ['book_unique_code' => $v['book_unique_code']]) }}"><i class="fa fa-list-ul" aria-hidden="true"></i> 章节列表</a>
                                                {{-- 如果本书可能已经完本则提供最新章节查看 --}}
                                                @if($v['message_id'] == 7)
                                                    &nbsp;|&nbsp;
                                                    <a href="javascript:show_detail('{{ route('admin.check_info.content.show', ['category_id' => $v['book_category_id'], 'unique_code' => $v['newest_chapter'], 'book_id' => $v['book_id']]) }}', '{{ $v['book_title'] }}')"><i class="fa fa-clone" aria-hidden="true"></i> 最新章节</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @include('admin.common.paging')
                </div>
            </div>
        </div>
    </main>
@endsection

@section('otherStaticSecond')
    <script type="text/javascript">

        $(function () {
            $('.every-record').click(function () {
                var checked = $(this).find('input[type="checkbox"]').prop('checked');
                $(this).find('input[type="checkbox"]').prop('checked', ! checked);
            });
            // 全选
            $('.checkbox-select-all').change(function () {
                var checked = $(this).prop('checked');
                $('.check-id').each(function () {
                    $(this).prop('checked', checked);
                });
            });
        });

        function show_detail(url, book_title)
        {
            layer.open({
                title: '《' + book_title + '》最新章节内容信息',
                type: 2,
                area: ['80%', '70%'],
                fixed: false, //不固定
                shadeClose: true,
                maxmin: true,
                resize:true,
                content: url
            });
        }

        function del_record(url, gotoUrl)
        {
            $ids = [];
            $('.check-id').each(function () {
                if ($(this).prop('checked')) {
                    $ids.push($(this).val());
                }
            });

            layer.confirm('确定删除已选中的记录？', {
                skin: 'layui-layer-molv',
                btn: ['确定','取消']
            }, function() {
                $.ajax({
                    'url': url,
                    'type': 'post',
                    'data': {'_token': '{{ csrf_token() }}', 'ids': $ids},
                    'dataType': 'json',
                    'success': function (results) {
                        if (results.status) {
                            layer.msg('更新成功！', {'anim': -1, 'time': 4,}, function () {
                                location.href = gotoUrl;
                            });
                        }
                    }
                });
            });
        }

        function update_record(url, gotoUrl, status)
        {
            $ids = [];
            $('.check-id').each(function () {
                if ($(this).prop('checked')) {
                    $ids.push($(this).val());
                }
            });

            layer.confirm('确定更新已选中的数据？', {
                skin: 'layui-layer-molv',
                btn: ['确定','取消']
            }, function() {
                $.ajax({
                    'url': url,
                    'type': 'post',
                    'data': {'_token': '{{ csrf_token() }}', 'ids': $ids, 'status': status},
                    'dataType': 'json',
                    'success': function (results) {
//                        if (results.status) {
                            layer.msg('更新成功！', {'anim': -1, 'time': 4,}, function () {
                                location.href = gotoUrl;
                            });
//                        }
                    }
                });
            });
        }

    </script>
@endsection
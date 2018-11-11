@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 《{{ $results['book']['title'] }}》 章节列表</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">章节管理</li>
                <li class="breadcrumb-item active"><a href="#">章节列表</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <h3 class="tile-title">本书简介</h3>
                        <table class="table table-bordered table-info-small">
                            <tbody>
                            <tr>
                                <th>名称</th>
                                <td width="40%">{{ $results['book']['title'] }}</td>
                                <th>作者</th>
                                <td width="40%">{{ $results['book']['author'] }}</td>
                            </tr>
                            <tr>
                                <th>最近更新日期</th>
                                <td>{{ $results['book']['last_update'] }}</td>
                                <th>是否完本</th>
                                <td>{{ $results['book']['finished'] }}</td>
                            </tr>
                            <tr>
                                <th>分类</th>
                                <td>{{ \App\Models\Category::categoryMap($results['book']['category_id']) }}</td>
                                <th>点击数</th>
                                <td>{{ $results['book']['view'] }}</td>
                            </tr>
                            <tr>
                                <th>最新章节唯一码</th>
                                <td>{{ $results['book']['newest_chapter'] }}</td>
                                <th>数据源</th>
                                <td><a href="{{ $results['book']['url'] }}" target="_blank">查看</a></td>
                            </tr>
                            <tr>
                                <th>操作</th>
                                <td colspan="3">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tile-body">
                        <form class="row" id="search-form" action="{{ route('admin.chapter.index', ['book_unique_code' => $results['book']['unique_code']]) }}" method="get">
                            <div class="form-group col-md-2">
                                <input class="form-control" autocomplete="off" type="text" name="title" value="{{ request()->get('title') }}" placeholder="标题">
                            </div>
                            <div class="form-group col-md-3">
                                <input class="form-control data-range" autocomplete="off" type="text" name="gte_number_of_words" value="{{ request()->get('gte_number_of_words') }}" placeholder="最小字数">
                                -
                                <input class="form-control data-range" autocomplete="off" type="text" name="lte_number_of_words" value="{{ request()->get('lte_number_of_words') }}" placeholder="最大字数">
                            </div>
                            <div class="form-group col-md-5">
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-info pull-right" href="javascript:$('#search-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>搜索</a>
                            </div>
                            <div class="form-group col-md-1 align-self-end">
                                <a class="btn btn-outline-secondary pull-right" href="{{ route('admin.chapter.index', ['book_unique_code' => $results['book']['unique_code']]) }}"><i class="fa fa-fw fa-lg fa-check-circle"></i>重置</a>
                            </div>
                            <input type="hidden" name="length" value="{{ request()->get('length') }}">
                        </form>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>标题</th>
                                <th>点击数</th>
                                <th>本章节字数</th>
                                <th width="160">上一章</th>
                                <th width="160">本章</th>
                                <th width="160">下一章</th>
                                <th>排序</th>
                                <th>源网站</th>
                                <th width="140">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($results['data']['list']))
                                    <?php $orderby = ($results['data']['page'] - 1) * $results['data']['length']; ?>
                                    @foreach($results['data']['list'] as $k => $v)
                                        <tr data-category-id="{{ $v['category_id'] }}" data-id="{{ $v['id'] }}">
                                            <td>{{ $v['title'] }}</td>
                                            <td>{{ $v['view'] }}</td>
                                            <td>{{ $v['number_of_words'] }}</td>

                                            <td id="prev_unique_code_{{ $v['id'] }}" data-title="{{ $v['prev_unique_code'] }}" class="prev_unique_code">
                                                {{ \App\Helper\ToolsHelper::subStr($v['prev_unique_code'], 0, 16) }}
                                            </td>
                                            <td id="unique_code{{ $v['id'] }}" data-title="{{ $v['unique_code'] }}" class="unique_code">
                                                {{ \App\Helper\ToolsHelper::subStr($v['unique_code'], 0, 16) }}
                                            </td>
                                            <td id="next_unique_code{{ $v['id'] }}" data-title="{{ $v['next_unique_code'] }}" class="next_unique_code">
                                                {{ \App\Helper\ToolsHelper::subStr($v['next_unique_code'], 0, 16) }}
                                            </td>

                                            <td @if(($k + $orderby) == $v['orderby']) class="font-green" @else class="font-red" @endif>
                                                {{ $v['orderby'] }}
                                            </td>
                                            <td>
                                                <a target="_blank" href="{{ $v['url'] }}">源网站</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.content.detail', ['content_id' => $v['id'], 'category_id' => $v['category_id']]) }}"><i class="fa fa-clone" aria-hidden="true"></i> 内容</a>
                                                &nbsp;|&nbsp;
                                                <a target="_blank" href="javascript:updateContent('{{ $v['id'] }}', '{{ $v['category_id'] }}', '{{ $v['url'] }}');"><i class="fa fa-refresh" aria-hidden="true"></i> 更新</a>
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

            // 把错误信息标色
            var len = $('.chapter').length;
            for (var i = 0; i < len; i++) {
                if (i > 0 && i < len - 1) {
                    var prev_unique_code = $('.chapter:eq('+ i +') > .prev_unique_code').text();
                    var next_unique_code = $('.chapter:eq('+ i +') > .next_unique_code').text();

                    var unique_code_prev = $('.chapter:eq('+ (i - 1) +') > .unique_code').text();
                    var unique_code_next = $('.chapter:eq('+ (i + 1) +') > .unique_code').text();

                    if (prev_unique_code != unique_code_prev) {
                        $('.chapter:eq('+ i +') > .prev_unique_code').addClass('font-red');
                        $('.chapter:eq('+ (i - 1) +') > .unique_code').addClass('font-red');
                    }

                    if (next_unique_code != unique_code_next) {
                        $('.chapter:eq('+ i +') > .next_unique_code').addClass('font-red');
                        $('.chapter:eq('+ (i + 1) +') > .unique_code').addClass('font-red');
                    }
                }
            }

            // 点击弹出层
            $('.prev_unique_code, .next_unique_code').click(function () {
                var obj = $(this);
                var data = {};
                data.field = obj.attr('class');
                data.category_id = obj.parents('tr').attr('data-category-id');
                data.id = obj.parents('tr').attr('data-id');
                data._token = '{{ csrf_token() }}';
                layer.prompt({
                    formType: 2,
                    value: obj.attr('data-title'),
                    title: '唯一码修改'
                }, function(val, index) {
                    data.value = val;
                    $.post('{{ route('admin.chapter.update') }}', data, function (results) {
                        if (results.status) {
                            obj.attr('data-title', val);
                            obj.text(val.substr(0, 16))
                        }
                        layer.close(index);
                    }, 'json');
                });
            });

            // tips显示
            $('.prev_unique_code, .next_unique_code, .unique_code').hover(function () {
                var id = $(this).attr('id');
                var title = $(this).attr('data-title');
                layer.tips(title, '#'+id, {
                    tips: [4, '#0FA6D8'],
                    area: ['250px', 'auto'],
                    time: 2000
                });
            });

        });

        // 修改method
        function changeMethod(url)
        {
            $.post(url, {'_token': '{{ csrf_token() }}'}, function (res) {
                if (res.status) {
                    location.reload();
                }
            }, 'json');
        }

        // 更新content
        function updateContent(chapter_id, category_id, url)
        {
            layer.confirm('确定更新该章节内容？', {
                skin: 'layui-layer-molv',
                btn: ['确定','取消']
            }, function() {
                var loadIndex = layer.load(2);
                var data = {
                    '_token': '{{ csrf_token() }}',
                    'chapter_id': chapter_id,
                    'category_id': category_id,
                    'url': url,
                };
                $.post('/admin/content/update', data, function (res) {
                    if (res.status) {
                        layer.close(loadIndex);
                        layer.msg('更新成功！');
                    }
                }, 'json');
            });
        }
    </script>
@endsection
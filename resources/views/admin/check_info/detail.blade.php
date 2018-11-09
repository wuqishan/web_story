@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> 异常书本信息</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">异常管理</li>
                <li class="breadcrumb-item active"><a href="#">异常书本信息</a></li>
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
                                    <td>{{ $results['book']['category_id'] }}</td>
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
                                    <th>解决方法</th>
                                    <td>
                                        @if($results['detail']['status'] == 1)
                                            @if($results['detail']['method'] == 1)
                                                <a href="javascript:changeMethod('{{ route('admin.check_info.method.change', ['check_info_id' => $results['detail']['id'], 'method_id' => '2']) }}')">章节删除重抓</a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="javascript:changeMethod('{{ route('admin.check_info.method.change', ['check_info_id' => $results['detail']['id'], 'method_id' => '3']) }}')">本书完全删除</a>
                                            @else
                                                {{ \App\Models\CheckBookInfo::$methodMap[$results['detail']['method']] }}
                                            @endif
                                        @else
                                            {{ \App\Models\CheckBookInfo::$methodMap[$results['detail']['method']] }}
                                        @endif
                                    </td>
                                    <th>状态</th>
                                    <td>{{ \App\Models\CheckBookInfo::$statusMap[$results['detail']['status']] }}</td>
                                </tr>
                                <tr>
                                    <th>异常</th>
                                    <td colspan="3">{{ $results['detail']['message'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>标题</th>
                                <th width="60">字数</th>
                                <th width="60">排序</thw>
                                <th width="160">上一章</th>
                                <th width="160">本章</th>
                                <th width="160">下一章</th>
                                <th width="70">源文章</th>
                                <th width="120">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($results['data']['list']))
                                    @foreach($results['data']['list'] as $k => $v)
                                        <tr class="chapter">
                                            <td>{{ $v['title'] }}</td>
                                            <td>{{ $v['number_of_words'] }}</td>
                                            <td @if($k == $v['orderby']) class="font-green" @else class="font-red" @endif>
                                                {{ $v['orderby'] }}
                                            </td>
                                            <td class="prev_unique_code">{{ \App\Helper\ToolsHelper::subStr($v['prev_unique_code'], 0, 16) }}</td>
                                            <td class="unique_code">{{ \App\Helper\ToolsHelper::subStr($v['unique_code'], 0, 16) }}</td>
                                            <td class="next_unique_code">{{ \App\Helper\ToolsHelper::subStr($v['next_unique_code'], 0, 16) }}</td>
                                            <td>
                                                <a target="_blank" href="{{ $v['url'] }}">源文章</a>
                                            </td>
                                            <td width="140">
                                                <a target="_blank" href="javascript:updateContent('{{ $v['id'] }}', '{{ $v['category_id'] }}', '{{ $v['url'] }}');"><i class="fa fa-refresh" aria-hidden="true"></i> 更新</a>
                                                &nbsp;|&nbsp;
                                                <a target="_blank" href="{{ route('admin.content.detail', ['content_id' => $v['id'], 'category_id' => $v['category_id']]) }}"><i class="fa fa-file-text" aria-hidden="true"></i> 详细</a>
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
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>有趣的灵魂错误数据修复</title>
    <script src="{{ asset('/static/js/jquery-2.1.4.min.js') }}" type="text/javascript"></script>
    <style>
        .bgreen {
            background-color: limegreen;
        }
        .bred {
            background-color: red;
        }
        .fgreen {
            color: limegreen;
        }
        .fred {
            color: red;
        }
    </style>
</head>
<body class="user-select">

<h3 style="text-align: center">书本信息-----<a href="{{ route('update-book-index') }}">返回</a></h3>
    <table cellspacing="0" cellpadding="10px" width="100%" border="2">
        <tr>
            <th>标题</th>
            <th>唯一码</th>
            <th>作者</th>
            <th>最近更新日期</th>
            <th>Url</th>
            <th>最新章节</th>
            <th>操作</th>
        </tr>
        <tr>
            <th align="left">{{ $results['book']['title'] }}</th>
            <td>{{ $results['book']['unique_code'] }}</td>
            <td>{{ $results['book']['author'] }}</td>
            <td>{{ $results['book']['last_update'] }}</td>
            <td>
                <a href="{{ $results['book']['url'] }}" target="_blank">本书</a>
            </td>
            <td>{{ $results['book']['newest_chapter'] }}</td>
            <td>
                @if($results['bookCheck']['method'] == 1)
                    待执行删除章节操作
                @elseif($results['bookCheck']['method'] == 1)
                    待执行删除本书操作
                @else
                    <a href="{{ route('update-chapter-update', ['method' => 1, 'id' => $results['bookCheck']['id']]) }}">删除章节</a> |
                    <a href="{{ route('update-chapter-update', ['method' => 2, 'id' => $results['bookCheck']['id']]) }}">删除本书</a>
                @endif
            </td>
        </tr>
    </table>
    <h3 style="text-align: center">对应章节信息</h3>
    <table cellspacing="0" cellpadding="3px" width="100%" border="1">
        <tr>
            <th>标题</th>
            <th>上一章唯一码</th>
            <th>本章节唯一码</th>
            <th>下一章唯一码</th>
            <th>Url</th>
            <th>排序</th>
        </tr>
        @foreach($results['data'] as $key => $v)
            <tr class="chapter">
                <th align="left">{{ $v['title'] }}</th>

                <td class="prev_unique_code">{{ $v['prev_unique_code'] }}</td>
                <td class="unique_code">{{ $v['unique_code'] }}</td>
                <td class="next_unique_code">{{ $v['next_unique_code'] }}</td>

                <td><a href="{{ $v['url'] }}" target="_blank">本章</a></td>
                <td @if($key == $v['orderby']) class="bgreen" @else class="bred" @endif>
                    {{ $v['orderby'] }}
                </td>
            </tr>
        @endforeach
    </table>

<script>
    $(function(){
        var len = $('.chapter').length;
        for (var i = 0; i < len; i++) {
            if (i > 0 && i < len - 1) {
                var prev_unique_code = $('.chapter:eq('+ i +') > .prev_unique_code').text();
                var next_unique_code = $('.chapter:eq('+ i +') > .next_unique_code').text();

                var unique_code_prev = $('.chapter:eq('+ (i - 1) +') > .unique_code').text();
                var unique_code_next = $('.chapter:eq('+ (i + 1) +') > .unique_code').text();

                if (prev_unique_code != unique_code_prev) {
                    $('.chapter:eq('+ i +') > .prev_unique_code').addClass('bred');
                    $('.chapter:eq('+ (i - 1) +') > .unique_code').addClass('bred');
                }

                if (next_unique_code != unique_code_next) {
                    $('.chapter:eq('+ i +') > .next_unique_code').addClass('bred');
                    $('.chapter:eq('+ (i + 1) +') > .unique_code').addClass('bred');
                }
            }
        }
    });
</script>
</body>
</html>

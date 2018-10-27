<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>有趣的灵魂错误数据修复</title>
    <script src="{{ asset('/static/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
</head>
<body class="user-select">

    <h3 style="text-align: center">问题数据列表</h3>

    <table cellspacing="0" cellpadding="10px" width="100%" border="2">
        <tr>
            <th>标题</th>
            <th>Url</th>
            <th>唯一码</th>
            <th>最新章节</th>
            <th>错误信息</th>
            <th>状态</th>
            <th>检测时间</th>
            <th>操作</th>
        </tr>
        @foreach($results['data'] as $v)
            <tr>
                <td>{{ $v['book_title'] }}</td>
                <td><a href="{{ $v['book_url'] }}" target="_blank">源数据</a></td>
                <td>{{ $v['book_unique_code'] }}</td>
                <td>{{ $v['newest_chapter'] }}</td>
                <td>{{ $v['message'] }}</td>
                <td>
                    @if($v['status'] == 0)
                        未解决
                    @else
                        已解决
                    @endif
                </td>
                <td>
                    @if($v['status'] == 0)
                        @if($v['method'] > 0)
                            正在解决...
                        @else
                            还未开始
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td>{{ $v['created_at'] }}</td>
                <td>
                    <a href="{{ route('update-chapter-index', ['book_unique_code' => $v['book_unique_code'], 'id' => $v['id']]) }}">章节列表</a>
                </td>
            </tr>
        @endforeach
    </table>

</body>
</html>

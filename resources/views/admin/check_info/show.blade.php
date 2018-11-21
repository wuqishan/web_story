@extends('admin.common.base')

@section('content')
    <main class="app-content" style="margin-top: 0px;margin-left: 0px;">
        <div class="row">
            <div class="col-md-12">
                <div class="tile-body">
                    <div class="tile">
                        <h3 class="tile-title">本书简介</h3>
                        <table class="table table-bordered table-info-small">
                            <tbody>
                            <tr>
                                <th>名称</th>
                                <td width="40%">{{ $results['book']['title'] }}</td>
                                <th>是否完本</th>
                                <td>
                                    <div class="toggle">
                                        <label>
                                            <input class="finished-toggle" data-book-id="{{ $results['book']['id'] }}" type="checkbox" @if($results['book']['finished'] == 1) checked @endif><span class="button-indecator"></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tile">
                        <h3 class="tile-title chapter-title">{{ $results['title'] }}</h3>
                        <div class="tile-body">{!! $results['content'] !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('otherStaticSecond')
    <script type="text/javascript">
        $(function () {
            // 完本修改
            $('.finished-toggle').change(function () {
                var book_id = $(this).attr('data-book-id');
                var finished = 0;
                if ($(this).prop('checked')) {
                    finished = 1;
                }
                var data = {'book_id': book_id, 'finished': finished, '_token': '{{ csrf_token() }}'};
                $.post('{{ route('admin.book.update.finished') }}', data, function (results) {
                    if (results.status) {
                        layer.msg('更新成功!');
                    }
                }, 'json');
            });
        });
    </script>
@endsection
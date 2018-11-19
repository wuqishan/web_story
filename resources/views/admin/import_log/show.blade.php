@extends('admin.common.base')

@section('content')
    <main class="app-content" style="margin-top: 0px;margin-left: 0px;">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                @if($results['detail']['type'] == 1)
                                    <th>书本</th>
                                    <th>作者</th>
                                    <th>分类</th>
                                @else
                                    <th>书本</th>
                                    <th>分类</th>
                                    <th>章节</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($results['book'] as $v)
                                    <tr>
                                        @if($results['detail']['type'] == 1)
                                            <td>{{ $v['title'] }}</td>
                                            <td>{{ $v['author'] }}</td>
                                            <td>{{ $v['category_name'] }}</td>
                                        @else
                                            <td>{{ $v['book_title'] }}</td>
                                            <td>{{ $v['category_name'] }}</td>
                                            <td>{{ $v['title'] }}</td>
                                        @endif
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

    </script>
@endsection
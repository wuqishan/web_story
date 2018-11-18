@extends('admin.common.base')

@section('content')
    <main class="app-content">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>书本</th>
                                <th>章节</th>
                                <th>分类</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($results['data']['list'] as $v)
                                    <tr>
                                        <td>{{ $v['number'] }}</td>
                                        <td>{{ \App\Models\ImportLog::$typeMap[$v['type']] }}</td>
                                        <td>{{ $v['created_at'] }}</td>
                                        <td width="130">
                                            <a href="javascript:show_detail('{{ route('admin.import_log.show', ['import_log_id' => $v['id']]) }}')"><i class="fa fa-clone" aria-hidden="true"></i> 详细</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{--@include('admin.common.paging')--}}
                </div>
            </div>
        </div>
    </main>
@endsection

@section('otherStaticSecond')
    <script type="text/javascript">

    </script>
@endsection
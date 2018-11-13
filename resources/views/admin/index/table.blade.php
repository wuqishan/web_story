@extends('admin.common.base')

@section('content')

    @include('admin.common.header')
    @include('admin.common.nav')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> 数据统计</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);"> 表格统计</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>标题</th>
                            @foreach($results['book']['group_by_category'] as $v)
                                <th>{{ $v['name'] }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>数量</th>
                                @foreach($results['book']['group_by_category'] as $v)
                                    <td>{{ $v['value'] }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>百分比%</th>
                                @foreach($results['book']['group_by_category'] as $v)
                                    <td>{{ sprintf("%1.4f", $v['value'] / $results['book']['total_number']) * 100 }}%</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>标题</th>
                            @foreach($results['book']['group_by_finished'] as $v)
                                <th>{{ $v['name'] }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>百分比%</th>
                            @foreach($results['book']['group_by_finished'] as $v)
                                <td>{{ sprintf("%1.4f", $v['value'] / $results['book']['total_number']) * 100 }}%</td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('otherStaticSecond')
    <script type="text/javascript">


    </script>
@endsection
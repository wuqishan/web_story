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
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>标题</th>
                            <th>作者</th>
                            <th>分类</th>
                            <th>最近更新日期</th>
                            <th>完本</th>
                            <th>点击数</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results['book']['max_view_5'] as $v)
                            <tr>
                                <td>
                                    <a target="_blank" href="{{ route('chapter-list', ['unique_code' => $v['unique_code']]) }}">
                                        {{ $v['title'] }}
                                    </a>
                                </td>
                                <td>{{ $v['author'] }}</td>
                                <td>{{ \App\Models\Category::categoryMap($v['category_id']) }}</td>
                                <td>{{ $v['last_update'] }}</td>
                                <td>{{ \App\Models\Book::$finishedMap[$v['finished']] }}</td>
                                <td>{{ $v['view'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">类型统计</h3>
                    <div class="embed-responsive">
                        <div style="width: 550px;height: 400px;" id="book_category"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">完本统计</h3>
                    <div class="embed-responsive">
                        <div style="width: 550px;height: 400px;" id="book_finished"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('otherStaticSecond')
    <!-- Page specific javascripts-->
{{--    <script type="text/javascript" src="{{ asset('/static/admin/js/plugins/chart.js') }}"></script>--}}
    <script type="text/javascript" src="{{ asset('/static/admin/js/plugins/echarts.common.min.js') }}"></script>
    <script type="text/javascript">

        var categoryOption = {
            title : {
                text: '类型统计',
                subtext: '按分类统计，总数: {{ array_sum(array_column($results['book']['group_by_category'], 'value')) }}',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                type: 'scroll',
                orient: 'vertical',
                right: 10,
                top: 20,
                bottom: 20
            },
            series : [
                {
                    name: '分类',
                    type: 'pie',
                    radius : '55%',
                    center: ['40%', '50%'],
                    data: $.parseJSON('{!! json_encode($results['book']['group_by_category']) !!}'),
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

        var chartCategory = echarts.init(document.getElementById('book_category'));
        chartCategory.setOption(categoryOption);


        var finishedOption = {
            title : {
                text: '完本统计',
                subtext: '按分类统计，总数: {{ array_sum(array_column($results['book']['group_by_finished'], 'value')) }}',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                type: 'scroll',
                orient: 'vertical',
                right: 10,
                top: 20,
                bottom: 20
            },
            series : [
                {
                    name: '姓名',
                    type: 'pie',
                    radius : '55%',
                    center: ['40%', '50%'],
                    data: $.parseJSON('{!! json_encode($results['book']['group_by_finished']) !!}'),
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

        var chartFinished = echarts.init(document.getElementById('book_finished'));
        chartFinished.setOption(finishedOption);

    </script>
@endsection
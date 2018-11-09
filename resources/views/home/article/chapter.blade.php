@extends('home.common.base')

@section('title'){{ $results['seo.title'] }}@endsection

@section('content')
    @include('home.common.header')
    <section class="container">
        <div class="content-wrap">
            <div class="content" style="margin-right: 0;">
                <article class="excerpt excerpt-1">
                    <a class="focus" href="javascript:void(0);" data-toggle="tooltip" title="" target="_blank">
                        <img class="thumb" src="{{ $results['book']['image_local_url'] }}" style="display: inline;">
                    </a>
                    <header>
                        <h2>
                            <a href="javascript:void(0);" title="{{ $results['book']['title'] }}" target="_blank">
                                {{ $results['book']['title'] }}
                            </a>
                        </h2>
                    </header>
                    <p class="meta">
                        <span class="views">作者：{{ $results['book']['author'] }}</span>
                        <time class="time">最近更新日期：{{ $results['book']['last_update'] }}</time>
                        <span class="views">阅读次数：{{ $results['book']['view'] }}</span>
                    </p>
                    <p class="note">{{ $results['book']['description'] }}</p>
                </article>
                <article class="chapter-list excerpt-1" style="padding: 20px">
                    @if(\App\Helper\ToolsHelper::isMobile())
                        @foreach($results['chapter']['list'] as $v)
                            <p>
                                <a href="{{ route('chapter-detail', ['category_id' => $v['category_id'], 'unique_code' => $v['unique_code']]) }}" target="_blank">
                                    {{ $v['title'] }}
                                </a>
                            </p>
                        @endforeach
                    @else
                        <table class="table table-bordered">
                            @for($i = 0; $i < count($results['chapter']['list']); $i += 3)
                                <tr>
                                    <td>
                                        @if(isset($results['chapter']['list'][$i]))
                                        <p>
                                            <a href="{{ route('chapter-detail', ['category_id' => $results['chapter']['list'][$i]['category_id'], 'unique_code' => $results['chapter']['list'][$i]['unique_code']]) }}" target="_blank">
                                                {{ $results['chapter']['list'][$i]['title'] }}
                                            </a>
                                        </p>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($results['chapter']['list'][$i + 1]))
                                        <p>
                                            <a href="{{ route('chapter-detail', ['category_id' => $results['chapter']['list'][$i + 1]['category_id'], 'unique_code' => $results['chapter']['list'][$i + 1]['unique_code']]) }}" target="_blank">
                                                {{ $results['chapter']['list'][$i + 1]['title'] }}
                                            </a>
                                        </p>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($results['chapter']['list'][$i + 2]))
                                        <p>
                                            <a href="{{ route('chapter-detail', ['category_id' => $results['chapter']['list'][$i + 2]['category_id'], 'unique_code' => $results['chapter']['list'][$i + 2]['unique_code']]) }}" target="_blank">
                                                {{ $results['chapter']['list'][$i + 2]['title'] }}
                                            </a>
                                        </p>
                                        @endif
                                    </td>
                                </tr>
                            @endfor
                        </table>
                    @endif
                    @include('home.common.paging', ['data' => $results['chapter'], 'chapter_list' => true])
                </article>
            </div>
        </div>
    </section>
    @include('home.common.footer')
@endsection
@section('otherStaticSecond')
    <script>
        $(function () {
            $.ajax({
                url: '{{ route('update-view') }}',
                type: 'get',
                data: {'type': 'book', 'id': '{{ $results['book']['id'] }}'}
            });
        });
    </script>
@endsection


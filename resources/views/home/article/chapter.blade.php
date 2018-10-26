@extends('home.common.base')

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
                    @foreach($results['chapter'] as $v)
                        <p>
                            <a href="{{ route('chapter-detail', ['unique_code' => $v['unique_code']]) }}" target="_blank">
                                {{ $v['title'] }}
                            </a>
                        </p>
                    @endforeach
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


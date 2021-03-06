@extends('home.common.base')

@section('title'){{ $results['seo.title'] }}@endsection

@section('content')
    @include('home.common.header')
    <section class="container">
        <div class="content-wrap">
            <div class="content" style="margin-right: 0;">
                <article class="chapter-list excerpt-1">
                    <header>
                        <h2 style="text-align: center">
                            <a href="javascript:void(0);" title="{{ $results['chapter']['title'] }}" target="_blank">
                                {{ $results['chapter']['title'] }}
                            </a>
                        </h2>
                    </header>
                    <p class="detail-action">
                        <span>
                            <a href="@if(empty($results['chapter']['prev_unique_code'])){{ 'javascript:void(0);' }}@else{{ route('chapter-detail', ['category_id' => $results['chapter']['category_id'], 'unique_code' => $results['chapter']['prev_unique_code']]) }}@endif">上一章</a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="{{ route('chapter-list', ['unique_code' => $results['chapter']['book_unique_code']]) }}">目录</a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="@if(empty($results['chapter']['next_unique_code'])){{ 'javascript:void(0);' }}@else{{ route('chapter-detail', ['category_id' => $results['chapter']['category_id'], 'unique_code' => $results['chapter']['next_unique_code']]) }}@endif">下一章</a>
                        </span>
                    </p>
                </article>
                <article class="chapter-list excerpt-1" style="padding: 20px;font-size: 20px;">
                    {!! $results['chapter']['content'] !!}
                    <p class="detail-action">
                        <span>
                            <a href="@if(empty($results['chapter']['prev_unique_code'])){{ 'javascript:void(0);' }}@else{{ route('chapter-detail', ['category_id' => $results['chapter']['category_id'], 'unique_code' => $results['chapter']['prev_unique_code']]) }}@endif">上一章</a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="{{ route('chapter-list', ['unique_code' => $results['chapter']['book_unique_code']]) }}">目录</a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="@if(empty($results['chapter']['next_unique_code'])){{ 'javascript:void(0);' }}@else{{ route('chapter-detail', ['category_id' => $results['chapter']['category_id'], 'unique_code' => $results['chapter']['next_unique_code']]) }}@endif">下一章</a>
                        </span>
                    </p>
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
                data: {'type': 'chapter', 'id': '{{ $results['chapter']['id'] }}', 'category_id': '{{ $results['chapter']['category_id'] }}'}
            });
        });
    </script>
@endsection
